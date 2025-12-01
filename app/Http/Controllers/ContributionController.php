<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContributionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Récupérer seulement les tontines actives où l'utilisateur est membre
        $tontines = $user->tontineMembers()
            ->with(['tontine.creator', 'tontine.members'])
            ->whereHas('tontine', function($query) {
                $query->where('status', 'active');
            })
            ->get()
            ->pluck('tontine');
            
        // Vérifier quelles tontines nécessitent une cotisation
        $tontinesNeedingContribution = [];
        foreach ($tontines as $tontine) {
            $tontinesNeedingContribution[$tontine->id] = $this->canUserContribute($tontine, $user->id);
        }

        return view('contributions.index', compact('tontines', 'tontinesNeedingContribution'));
    }
    
    private function canUserContribute($tontine, $userId)
    {
        if ($tontine->status !== 'active') {
            return false;
        }
        
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
                return true;
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