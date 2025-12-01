<?php

namespace App\Http\Controllers;

use App\Models\Tontine;
use App\Models\Contribution;
use App\Models\Distribution;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Statistiques générales
        $totalTontines = $user->tontineMembers()->count();
        $activeTontines = $user->tontineMembers()
            ->whereHas('tontine', function($query) {
                $query->where('status', 'active');
            })->count();
        
        $totalContributions = Transaction::where('user_id', $user->id)
            ->where('type', 'contribution')
            ->where('status', 'completed')
            ->sum('amount');
            
        $totalDistributions = Transaction::where('user_id', $user->id)
            ->where('type', 'distribution')
            ->where('status', 'completed')
            ->sum('amount');

        // Tontines récentes
        $recentTontines = Tontine::with(['creator', 'members'])
            ->whereHas('members', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->latest()
            ->take(5)
            ->get();

        // Contributions en attente
        $pendingContributions = $user->contributions()
            ->with('tontine')
            ->where('status', 'pending')
            ->where('due_date', '<=', now()->addDays(7))
            ->get();

        // Notifications récentes
        $notifications = $user->notifications()
            ->where('is_read', false)
            ->latest()
            ->take(5)
            ->get();
            
        // Tontines nécessitant une cotisation (seulement les actives)
        $tontinesNeedingContribution = $this->getTontinesNeedingContribution($user);

        return view('dashboard', compact(
            'totalTontines', 
            'activeTontines', 
            'totalContributions', 
            'totalDistributions',
            'recentTontines',
            'pendingContributions',
            'notifications',
            'tontinesNeedingContribution',
            'user'
        ));
    }
    
    private function getTontinesNeedingContribution($user)
    {
        // Seulement les tontines actives
        $tontines = Tontine::whereHas('members', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'active')->get();
        
        $needingContribution = [];
        
        foreach ($tontines as $tontine) {
            if (!$this->canUserContribute($tontine, $user->id)) {
                continue;
            }
            $needingContribution[] = $tontine;
        }
        
        return collect($needingContribution);
    }
    
    private function canUserContribute(Tontine $tontine, $userId)
    {
        $now = now();
        $startDate = $tontine->start_date;
        
        switch ($tontine->frequency) {
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
                return false;
        }
        
        $hasContributed = Transaction::where('tontine_id', $tontine->id)
            ->where('user_id', $userId)
            ->where('type', 'contribution')
            ->where('status', 'completed')
            ->whereBetween('created_at', [$periodStart, $periodEnd])
            ->exists();
            
        return !$hasContributed;
    }
}