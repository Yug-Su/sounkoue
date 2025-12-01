<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $wallet = $user->getOrCreateWallet();
        
        // Transactions récentes
        $transactions = Transaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(5);
            
        // Statistiques
        $totalRecharges = Transaction::where('user_id', $user->id)
            ->where('type', 'recharge')
            ->where('status', 'completed')
            ->sum('amount');
            
        $totalWithdrawals = Transaction::where('user_id', $user->id)
            ->where('type', 'withdrawal')
            ->where('status', 'completed')
            ->sum('amount');

        return view('wallet.index', compact('wallet', 'transactions', 'totalRecharges', 'totalWithdrawals'));
    }

    public function showRecharge()
    {
        $user = Auth::user();
        $wallet = $user->getOrCreateWallet();
        
        return view('wallet.recharge', compact('wallet'));
    }

    public function processRecharge(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100',
            'phone_number' => 'required|string'
        ]);

        $user = Auth::user();
        $wallet = $user->getOrCreateWallet();

        try {
            $wallet->addFunds(
                $request->amount,
                "Rechargement depuis {$request->phone_number}"
            );

            return redirect()->route('dashboard')
                ->with('success', 'Wallet rechargé avec succès !');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100',
            'phone_number' => 'required|string'
        ]);

        $user = Auth::user();
        $wallet = $user->getOrCreateWallet();

        try {
            $wallet->deductFunds(
                $request->amount,
                "Retrait vers {$request->phone_number}"
            );

            return back()->with('success', 'Retrait effectué avec succès !');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function showWithdraw()
    {
        $user = Auth::user();
        $wallet = $user->getOrCreateWallet();
        
        return view('wallet.withdraw', compact('wallet', 'user'));
    }

    public function processWithdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100',
            'phone_number' => 'required|string'
        ]);

        $user = Auth::user();
        $wallet = $user->getOrCreateWallet();

        if ($wallet->balance < $request->amount) {
            return back()->with('error', 'Solde insuffisant.');
        }

        try {
            $wallet->deductFunds(
                $request->amount,
                "Retrait vers {$request->phone_number}"
            );

            return redirect()->route('dashboard')
                ->with('success', 'Retrait initié avec succès !');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}