<?php

namespace App\Http\Controllers;

use App\Models\Tontine;
use App\Models\TontineMember;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TontineController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Tontine::with(['creator', 'members.user'])
            ->where('creator_id', $user->id)
            ->orWhereHas('members', function($query) use ($user) {
                $query->where('user_id', $user->id);
            });

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search, $user) {
                $q->where(function($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%")
                         ->orWhere('description', 'like', "%{$search}%");
                })->where(function($subQ) use ($user) {
                    $subQ->where('creator_id', $user->id)
                         ->orWhereHas('members', function($memberQ) use ($user) {
                             $memberQ->where('user_id', $user->id);
                         });
                });
            });
        }

        $tontines = $query->paginate(10);

        if ($request->expectsJson()) {
            return response()->json([
                'html' => view('tontines.partials.grid', compact('tontines'))->render()
            ]);
        }

        return view('tontines.index', compact('tontines'));
    }

    public function create()
    {
        return view('tontines.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount_per_contribution' => 'required|numeric|min:1000',
            'frequency' => 'required|in:daily,weekly,biweekly,monthly,quarterly',
            'max_members' => 'required|integer|min:3|max:50',
            'rotation_order' => 'required|in:random,alphabetical,custom',
            'start_date' => 'nullable|date|after:today',
            'require_approval' => 'boolean',
            'is_private' => 'boolean',
        ]);

        $tontine = Tontine::create([
            'name' => $request->name,
            'description' => $request->description,
            'amount_per_contribution' => $request->amount_per_contribution,
            'frequency' => $request->frequency,
            'max_members' => $request->max_members,
            'rotation_order' => $request->rotation_order,
            'start_date' => $request->start_date,
            'require_approval' => $request->boolean('require_approval'),
            'is_private' => $request->boolean('is_private'),
            'creator_id' => Auth::id(),
            'status' => 'pending'
        ]);

        // Générer un code d'invitation unique
        $inviteCode = strtoupper(substr(md5($tontine->id . time()), 0, 8));
        $tontine->update(['invite_code' => $inviteCode]);

        // Ajouter le créateur comme premier membre
        TontineMember::create([
            'tontine_id' => $tontine->id,
            'user_id' => Auth::id(),
            'status' => 'active',
            'position_in_rotation' => 1,
            'joined_at' => now()
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'tontine' => $tontine,
                'invite_link' => route('tontines.join-by-code', $inviteCode)
            ]);
        }

        return redirect()->route('tontines.show', $tontine)
            ->with('success', 'Tontine créée avec succès !');
    }

    public function show(Tontine $tontine)
    {
        $tontine->load(['creator', 'members.user', 'contributions.user', 'distributions.recipient']);
        
        // Vérifier si l'utilisateur peut cotiser selon la fréquence
        $canContribute = $this->canUserContribute($tontine, auth()->id());
        
        return view('tontines.show', compact('tontine', 'canContribute'));
    }
    
    private function canUserContribute(Tontine $tontine, $userId)
    {
        if ($tontine->status !== 'active') {
            return true; // Peut toujours cotiser si la tontine n'est pas active
        }
        
        // Calculer la période actuelle selon la fréquence
        $now = now();
        $startDate = $tontine->start_date;
        
        switch ($tontine->frequency) {
            case 'daily':
                $periodStart = $startDate->copy()->addDays(floor($startDate->diffInDays($now)));
                $periodEnd = $periodStart->copy()->addDay();
                break;
            case 'weekly':
                $periodStart = $startDate->copy()->addWeeks(floor($startDate->diffInWeeks($now)));
                $periodEnd = $periodStart->copy()->addWeek();
                break;
            case 'biweekly':
                $weeksDiff = floor($startDate->diffInWeeks($now) / 2) * 2;
                $periodStart = $startDate->copy()->addWeeks($weeksDiff);
                $periodEnd = $periodStart->copy()->addWeeks(2);
                break;
            case 'monthly':
                $periodStart = $startDate->copy()->addMonths(floor($startDate->diffInMonths($now)));
                $periodEnd = $periodStart->copy()->addMonth();
                break;
            case 'quarterly':
                $monthsDiff = floor($startDate->diffInMonths($now) / 3) * 3;
                $periodStart = $startDate->copy()->addMonths($monthsDiff);
                $periodEnd = $periodStart->copy()->addMonths(3);
                break;
            default:
                return true;
        }
        
        // Vérifier s'il y a déjà une cotisation dans cette période
        $hasContributed = Transaction::where('tontine_id', $tontine->id)
            ->where('user_id', $userId)
            ->where('type', 'contribution')
            ->where('status', 'completed')
            ->whereBetween('created_at', [$periodStart, $periodEnd])
            ->exists();
            
        return !$hasContributed;
    }

    public function edit(Tontine $tontine)
    {
        if ($tontine->creator_id !== Auth::id()) {
            abort(403, 'Action non autorisée');
        }

        return view('tontines.edit', compact('tontine'));
    }

    public function update(Request $request, Tontine $tontine)
    {
        if ($tontine->creator_id !== Auth::id()) {
            abort(403, 'Action non autorisée');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount_per_contribution' => 'required|numeric|min:1000',
            'frequency' => 'required|in:daily,weekly,biweekly,monthly,quarterly',
            'max_members' => 'required|integer|min:3|max:50'
        ]);

        $tontine->update($request->only([
            'name', 'description', 'amount_per_contribution', 
            'frequency', 'max_members'
        ]));

        return redirect()->route('tontines.show', $tontine)
            ->with('success', 'Tontine mise à jour avec succès');
    }

    public function destroy(Tontine $tontine)
    {
        if ($tontine->creator_id !== Auth::id()) {
            abort(403, 'Action non autorisée');
        }
        
        $tontine->delete();
        
        return redirect()->route('tontines.index')
            ->with('success', 'Tontine supprimée avec succès');
    }

    public function join(Tontine $tontine)
    {
        $user = Auth::user();
        
        if ($tontine->members()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'Vous êtes déjà membre de cette tontine');
        }

        if ($tontine->members()->count() >= $tontine->max_members) {
            return back()->with('error', 'Cette tontine est complète');
        }

        $position = $tontine->members()->max('position_in_rotation') + 1;

        TontineMember::create([
            'tontine_id' => $tontine->id,
            'user_id' => $user->id,
            'status' => 'active',
            'position_in_rotation' => $position,
            'joined_at' => now()
        ]);

        return back()->with('success', 'Vous avez rejoint la tontine avec succès');
    }

    public function leave(Tontine $tontine)
    {
        $user = Auth::user();
        
        $member = $tontine->members()->where('user_id', $user->id)->first();
        
        if (!$member) {
            return back()->with('error', 'Vous n\'êtes pas membre de cette tontine');
        }

        if ($tontine->status === 'active') {
            return back()->with('error', 'Impossible de quitter une tontine active');
        }

        $member->delete();
        
        return back()->with('success', 'Vous avez quitté la tontine');
    }

    public function start(Tontine $tontine)
    {
        if ($tontine->creator_id !== Auth::id()) {
            abort(403, 'Action non autorisée');
        }
        
        if ($tontine->status !== 'pending') {
            return back()->with('error', 'Cette tontine ne peut pas être démarrée');
        }

        if ($tontine->members()->count() < 3) {
            return back()->with('error', 'Minimum 3 membres requis pour démarrer');
        }

        $tontine->update([
            'status' => 'active',
            'start_date' => now(),
            'current_round' => 1
        ]);
        
        // Initialiser l'ordre des tours et créer les rounds
        $tontine->initializeTurnOrder();

        return back()->with('success', 'Tontine démarrée avec succès');
    }

    public function joinByCode($code)
    {
        $tontine = Tontine::where('invite_code', $code)->firstOrFail();
        
        if (auth()->check()) {
            return redirect()->route('tontines.show', $tontine)->with('from_invite', true);
        }
        
        // Stocker l'ID de la tontine dans la session
        session(['tontine_to_join' => $tontine->id]);
        
        return redirect()->route('login', ['tontine_to_join' => $tontine->id]);
    }
}