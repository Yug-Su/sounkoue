@extends('layouts.app')

@section('title', 'Mon Wallet - Soun Kouê')
@section('page-title', 'Mon Wallet')
@section('page-description', 'Gérez votre portefeuille électronique Soun Kouê')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-8">
    <!-- Wallet Card -->
    <div class="mb-8">
        <div class="relative bg-gradient-to-br from-cauri-gold to-cauri-gold-light rounded-3xl p-8 shadow-xl overflow-hidden">
            <!-- Pattern Background -->
            <div class="absolute inset-0 opacity-10">
                <div class="absolute inset-0" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 20px, rgba(111, 47, 47, 0.1) 20px, rgba(111, 47, 47, 0.1) 40px);"></div>
            </div>
            
            <!-- Cauri watermark -->
            <div class="absolute top-1/2 right-8 -translate-y-1/2 opacity-10">
                <div class="text-[200px] text-terre-marron">🐚</div>
            </div>

            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-4">
                    <div class="text-2xl text-terre-marron">🐚</div>
                    <span class="text-terre-marron/80 text-lg-medium">Solde du wallet</span>
                </div>
                <div class="text-5xl font-bold text-terre-marron mb-6">
                    {{ number_format($wallet->balance, 0, ',', ' ') }} FCFA
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('wallet.recharge') }}" class="bg-terre-marron hover:bg-terre-marron-dark text-ivoire px-6 py-3 rounded-xl transition-colors">
                        Recharger
                    </a>
                    <a href="{{ route('wallet.withdraw') }}" class="border border-terre-marron text-terre-marron hover:bg-terre-marron/10 px-6 py-3 rounded-xl transition-colors">
                        Retirer
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl p-6 border border-cauri-gold/20 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-3">
                    <i data-lucide="arrow-down" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-terre-marron">{{ number_format($totalRecharges, 0, ',', ' ') }}</div>
                    <div class="text-sm text-terre-marron/70">Total rechargé (FCFA)</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-cauri-gold/20 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl p-3">
                    <i data-lucide="arrow-up" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-terre-marron">{{ number_format($totalWithdrawals, 0, ',', ' ') }}</div>
                    <div class="text-sm text-terre-marron/70">Total retiré (FCFA)</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-cauri-gold/20 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="bg-gradient-to-br from-cauri-gold to-cauri-gold-light rounded-xl p-3">
                    <i data-lucide="activity" class="w-6 h-6 text-terre-marron"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-terre-marron">{{ $transactions->count() }}</div>
                    <div class="text-sm text-terre-marron/70">Transactions ce mois</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-2xl p-6 border border-cauri-gold/20 shadow-sm">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-sang-bleu font-bold text-terre-marron">Transactions récentes</h3>
        </div>

        @if($transactions->count() > 0)
            <div class="space-y-4">
                @foreach($transactions as $transaction)
                    <div class="flex items-center justify-between p-4 bg-ivoire rounded-xl">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center
                                @if($transaction->type === 'recharge') bg-green-100
                                @elseif($transaction->type === 'withdrawal') bg-red-100
                                @elseif($transaction->type === 'contribution') bg-blue-100
                                @else bg-gray-100
                                @endif">
                                @if($transaction->type === 'recharge')
                                    <i data-lucide="arrow-down" class="w-5 h-5 text-green-600"></i>
                                @elseif($transaction->type === 'withdrawal')
                                    <i data-lucide="arrow-up" class="w-5 h-5 text-red-600"></i>
                                @elseif($transaction->type === 'contribution')
                                    <i data-lucide="send" class="w-5 h-5 text-blue-600"></i>
                                @else
                                    <i data-lucide="activity" class="w-5 h-5 text-gray-600"></i>
                                @endif
                            </div>
                            <div>
                                <div class="font-medium text-terre-marron">
                                    @if($transaction->type === 'recharge') Rechargement
                                    @elseif($transaction->type === 'withdrawal') Retrait
                                    @elseif($transaction->type === 'contribution') Cotisation
                                    @else {{ ucfirst($transaction->type) }}
                                    @endif
                                </div>
                                <div class="text-sm text-terre-marron/60">
                                    {{ $transaction->description }}
                                </div>
                                <div class="text-xs text-terre-marron/50">
                                    {{ $transaction->created_at->format('d/m/Y à H:i') }}
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold
                                @if($transaction->type === 'recharge') text-green-600
                                @elseif($transaction->type === 'withdrawal') text-red-600
                                @elseif($transaction->type === 'contribution') text-blue-600
                                @else text-terre-marron
                                @endif">
                                @if($transaction->type === 'recharge') +
                                @elseif($transaction->type === 'withdrawal' || $transaction->type === 'contribution') -
                                @endif
                                {{ number_format($transaction->amount, 0, ',', ' ') }} FCFA
                            </div>
                            <div class="text-xs text-terre-marron/50">
                                {{ ucfirst($transaction->status) }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $transactions->links() }}
            </div>
        @else
            <div class="text-center py-8">
                <div class="text-6xl mb-4">🐚</div>
                <h4 class="text-lg font-sang-bleu text-terre-marron mb-2">Aucune transaction</h4>
                <p class="text-terre-marron/60 mb-4">Vos transactions apparaîtront ici</p>
                <a href="{{ route('wallet.recharge') }}" class="bg-terre-marron text-ivoire px-6 py-3 rounded-xl hover:bg-terre-marron-dark transition-colors">
                    Première recharge
                </a>
            </div>
        @endif
    </div>
</div>
@endsection