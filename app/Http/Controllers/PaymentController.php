<?php

namespace App\Http\Controllers;

use App\Models\Tontine;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function showPaymentForm(Tontine $tontine)
    {
        $user = Auth::user();
        $wallet = $user->getOrCreateWallet();
        
        // Vérifier si l'utilisateur est membre de la tontine
        $member = $tontine->members()->where('user_id', $user->id)->first();
        if (!$member) {
            return redirect()->route('tontines.show', $tontine)
                ->with('error', 'Vous devez être membre de cette tontine pour cotiser.');
        }
        
        // Vérifier si l'utilisateur peut cotiser selon la fréquence
        if (!$this->canUserContribute($tontine, $user->id)) {
            return redirect()->route('tontines.show', $tontine)
                ->with('error', 'Vous avez déjà cotisé pour cette période.');
        }

        return view('payments.form', compact('tontine', 'wallet'));
    }

    public function processPayment(Request $request, Tontine $tontine)
    {
        $request->validate([
            'payment_method' => 'required|in:wallet,mobile_money',
            'phone_number' => 'required_if:payment_method,mobile_money|nullable|string'
        ]);

        $user = Auth::user();
        $wallet = $user->getOrCreateWallet();
        
        // Vérifier si l'utilisateur peut cotiser selon la fréquence
        if (!$this->canUserContribute($tontine, $user->id)) {
            return back()->with('error', 'Vous avez déjà cotisé pour cette période.');
        }

        try {
            DB::beginTransaction();

            if ($request->payment_method === 'wallet') {
                // Paiement par wallet
                if ($wallet->balance < $tontine->amount_per_contribution) {
                    return back()->with('error', 'Solde insuffisant dans votre wallet.');
                }

                $wallet->deductFunds(
                    $tontine->amount_per_contribution,
                    "Cotisation pour {$tontine->name}"
                );
            }

            // Créer la transaction de cotisation
            Transaction::create([
                'user_id' => $user->id,
                'tontine_id' => $tontine->id,
                'type' => 'contribution',
                'amount' => $tontine->amount_per_contribution,
                'currency' => 'XOF',
                'status' => 'completed',
                'payment_method' => $request->payment_method,
                'phone_number' => $request->phone_number,
                'description' => "Cotisation pour {$tontine->name}",
                'processed_at' => now()
            ]);

            DB::commit();

            return redirect()->route('tontines.show', $tontine)
                ->with('success', 'Cotisation effectuée avec succès !');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors du paiement: ' . $e->getMessage());
        }
    }
    
    private function canUserContribute(Tontine $tontine, $userId)
    {
        if ($tontine->status !== 'active') {
            return true;
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