@extends('layouts.app')

@section('title', 'Tableau de bord - Soun Kouê')
@section('page-title', 'Tableau de bord')
@section('page-description')
    Bonjour {{ auth()->user()->name }} ! Voici un aperçu de vos tontines
@endsection

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
                    {{ number_format($user->getOrCreateWallet()->balance, 0, ',', ' ') }} FCFA
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

    <!-- Quick Actions -->
    <div class="mb-8">
        <h3 class="text-xl-bold font-sang-bleu text-terre-marron mb-4">Actions rapides</h3>
        <div class="grid md:grid-cols-3 gap-4">
            <button onclick="window.location.href='{{ route('contributions.index') }}'" class="relative group bg-gradient-to-br from-terre-marron to-terre-marron-dark text-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all overflow-hidden @if($tontinesNeedingContribution->count() > 0) animate-hammer @endif">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute inset-0" style="background-image: repeating-linear-gradient(60deg, transparent, transparent 15px, rgba(255, 189, 89, 0.1) 15px, rgba(255, 189, 89, 0.1) 30px);"></div>
                </div>
                <div class="relative z-10 flex items-center gap-4">
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3 group-hover:scale-110 transition-transform">
                        <i data-lucide="send" class="w-6 h-6 text-white"></i>
                    </div>
                    <span class="text-white text-lg-medium">Cotiser</span>
                </div>
            </button>

            <button onclick="window.location.href='{{ route('tontines.create') }}'" class="relative group bg-gradient-to-br from-cauri-gold to-cauri-gold-light text-terre-marron rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute inset-0" style="background-image: repeating-linear-gradient(30deg, transparent, transparent 10px, rgba(111, 47, 47, 0.1) 10px, rgba(111, 47, 47, 0.1) 20px);"></div>
                </div>
                <div class="relative z-10 flex items-center gap-4">
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3 group-hover:scale-110 transition-transform">
                        <i data-lucide="plus" class="w-6 h-6 text-terre-marron"></i>
                    </div>
                    <span class="text-terre-marron text-lg-medium">Créer une tontine</span>
                </div>
            </button>

            <button onclick="window.location.href='{{ route('tontines.index') }}'" class="relative group bg-gradient-to-br from-terre-marron to-terre-marron-dark text-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute inset-0" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 12px, rgba(255, 189, 89, 0.1) 12px, rgba(255, 189, 89, 0.1) 24px);"></div>
                </div>
                <div class="relative z-10 flex items-center gap-4">
                    <div class="bg-white/20 backdrop-blur-sm rounded-xl p-3 group-hover:scale-110 transition-transform">
                        <i data-lucide="user-plus" class="w-6 h-6 text-white"></i>
                    </div>
                    <span class="text-white text-lg-medium">Mes tontines</span>
                </div>
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl p-6 border border-cauri-gold/20 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="bg-gradient-to-br from-cauri-gold to-cauri-gold-light rounded-xl p-3">
                    <i data-lucide="users" class="w-6 h-6 text-terre-marron"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-terre-marron">{{ $activeTontines }}</div>
                    <div class="text-sm text-terre-marron/70">Tontines actives</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-cauri-gold/20 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="bg-gradient-to-br from-terre-marron to-terre-marron-dark rounded-xl p-3">
                    <i data-lucide="trending-up" class="w-6 h-6 text-cauri-gold"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-terre-marron">{{ number_format($totalContributions, 0, ',', ' ') }}</div>
                    <div class="text-sm text-terre-marron/70">Total cotisé (FCFA)</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-6 border border-cauri-gold/20 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="bg-gradient-to-br from-cauri-gold to-cauri-gold-light rounded-xl p-3">
                    <i data-lucide="clock" class="w-6 h-6 text-terre-marron"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-terre-marron">{{ $tontinesNeedingContribution->count() }}</div>
                    <div class="text-sm text-terre-marron/70">Cotisations en attente</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Tontines -->
    <div>
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl-bold font-sang-bleu text-terre-marron">Mes tontines</h3>
            <a href="{{ route('tontines.index') }}" class="text-terre-marron hover:bg-cauri-gold/10 px-4 py-2 rounded-lg transition-colors">
                Voir tout
            </a>
        </div>

        <div class="space-y-4">
            @forelse($recentTontines as $tontine)
                <!-- Tontine Card -->
                <div onclick="window.location.href='{{ route('tontines.show', $tontine) }}'" class="bg-white rounded-2xl p-6 border border-cauri-gold/20 hover:border-cauri-gold hover:shadow-lg transition-all cursor-pointer">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h4 class="text-lg-medium font-sang-bleu text-terre-marron mb-1">{{ $tontine->name }}</h4>
                            <div class="flex items-center gap-4 text-sm text-terre-marron/70">
                                <div class="flex items-center gap-1">
                                    <i data-lucide="users" class="w-4 h-4"></i>
                                    <span>{{ $tontine->members->count() }} membres</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="text-cauri-gold">🐚</span>
                                    <span>{{ number_format($tontine->amount_per_contribution, 0, ',', ' ') }} FCFA</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-1 
                            @if($tontine->status === 'active') text-green-600 bg-green-50
                            @elseif($tontine->status === 'pending') text-orange-600 bg-orange-50
                            @else text-gray-600 bg-gray-50
                            @endif px-3 py-1 rounded-full text-sm">
                            @if($tontine->status === 'active')
                                <i data-lucide="check-circle" class="w-4 h-4"></i>
                            @else
                                <i data-lucide="alert-circle" class="w-4 h-4"></i>
                            @endif
                            <span>@if($tontine->status === 'active') Actif @elseif($tontine->status === 'pending') En attente @else {{ ucfirst($tontine->status) }} @endif</span>
                        </div>
                    </div>

                    @if($tontine->status === 'active')
                        <div class="mb-3">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-terre-marron/70">Progression du cycle</span>
                                <span class="text-terre-marron">{{ round(($tontine->current_round / $tontine->members->count()) * 100) }}%</span>
                            </div>
                            <div class="h-2 bg-ivoire rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-terre-marron to-cauri-gold rounded-full transition-all" style="width: {{ ($tontine->current_round / $tontine->members->count()) * 100 }}%"></div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center text-sm">
                            <span class="text-terre-marron/70">
                                Tour actuel : <span class="text-terre-marron">{{ $tontine->current_round }}/{{ $tontine->members->count() }}</span>
                            </span>
                            @if($tontine->start_date)
                                <span class="text-terre-marron/70">
                                    Démarré : <span class="text-terre-marron">{{ $tontine->start_date->format('d/m/Y') }}</span>
                                </span>
                            @endif
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-white rounded-2xl p-8 border border-cauri-gold/20 text-center">
                    <div class="text-6xl mb-4">🐚</div>
                    <h4 class="text-lg font-sang-bleu text-terre-marron mb-2">Aucune tontine pour le moment</h4>
                    <p class="text-terre-marron/60 mb-4">Créez votre première tontine ou rejoignez un groupe existant</p>
                    <a href="{{ route('tontines.create') }}" class="bg-terre-marron text-ivoire px-6 py-3 rounded-xl hover:bg-terre-marron-dark transition-colors">
                        Créer une tontine
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
@keyframes hammer {
    0%, 100% { transform: translateY(0) rotate(0deg) scale(1); box-shadow: 0 4px 8px rgba(255, 189, 89, 0.3); }
    5% { transform: translateY(-8px) rotate(-3deg) scale(1.05); box-shadow: 0 8px 16px rgba(255, 189, 89, 0.5); }
    15% { transform: translateY(2px) rotate(2deg) scale(0.98); box-shadow: 0 2px 4px rgba(255, 189, 89, 0.4); }
    25% { transform: translateY(-6px) rotate(-2deg) scale(1.03); box-shadow: 0 6px 12px rgba(255, 189, 89, 0.5); }
    35% { transform: translateY(1px) rotate(1deg) scale(0.99); box-shadow: 0 3px 6px rgba(255, 189, 89, 0.4); }
    45% { transform: translateY(-4px) rotate(-1deg) scale(1.02); box-shadow: 0 5px 10px rgba(255, 189, 89, 0.4); }
    55% { transform: translateY(0) rotate(0deg) scale(1); box-shadow: 0 4px 8px rgba(255, 189, 89, 0.3); }
    65% { transform: translateY(-3px) rotate(1deg) scale(1.01); box-shadow: 0 4px 8px rgba(255, 189, 89, 0.4); }
    75% { transform: translateY(1px) rotate(-0.5deg) scale(0.99); box-shadow: 0 3px 6px rgba(255, 189, 89, 0.3); }
    85% { transform: translateY(-2px) rotate(0.5deg) scale(1.01); box-shadow: 0 3px 6px rgba(255, 189, 89, 0.4); }
    95% { transform: translateY(0) rotate(0deg) scale(1); box-shadow: 0 4px 8px rgba(255, 189, 89, 0.3); }
}

@keyframes pulse-glow {
    0%, 100% { background: linear-gradient(to bottom right, rgb(111, 47, 47), rgb(89, 37, 37)); }
    50% { background: linear-gradient(to bottom right, rgb(131, 67, 67), rgb(111, 47, 47)); }
}

.animate-hammer {
    animation: hammer 1.5s ease-in-out infinite, pulse-glow 2s ease-in-out infinite;
    position: relative;
    z-index: 10;
}
</style>
@endsection