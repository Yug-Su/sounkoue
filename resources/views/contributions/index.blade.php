@extends('layouts.app')

@section('title', 'Cotiser - Soun Kouê')
@section('page-title', 'Effectuer une cotisation')
@section('page-description', 'Choisissez la tontine pour laquelle vous souhaitez cotiser')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 sm:py-8">
    @if($tontines->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($tontines as $tontine)
                <div class="bg-white rounded-2xl p-6 border border-cauri-gold/20 hover:border-cauri-gold hover:shadow-lg transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-sang-bleu font-bold text-terre-marron">{{ $tontine->name }}</h3>
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            @if($tontine->status === 'active') bg-green-100 text-green-800
                            @elseif($tontine->status === 'pending') bg-yellow-100 text-yellow-800
                            @endif">
                            @if($tontine->status === 'active') Actif
                            @elseif($tontine->status === 'pending') En attente
                            @endif
                        </span>
                    </div>

                    <div class="space-y-3 mb-6">
                        <div class="flex items-center justify-between">
                            <span class="text-terre-marron/70 text-sm">Cotisation</span>
                            <span class="font-bold text-terre-marron">{{ number_format($tontine->amount_per_contribution, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-terre-marron/70 text-sm">Membres</span>
                            <span class="text-terre-marron">{{ $tontine->members->count() }}/{{ $tontine->max_members }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-terre-marron/70 text-sm">Fréquence</span>
                            <span class="text-terre-marron">
                                @if($tontine->frequency === 'weekly') Hebdo
                                @elseif($tontine->frequency === 'monthly') Mensuel
                                @elseif($tontine->frequency === 'quarterly') Trimestriel
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('payments.form', $tontine) }}" class="flex-1 bg-terre-marron text-ivoire px-4 py-3 rounded-xl hover:bg-terre-marron-dark transition-colors text-center font-medium @if($tontinesNeedingContribution[$tontine->id] ?? false) animate-hammer @endif">
                            @if($tontinesNeedingContribution[$tontine->id] ?? false)
                                Cotiser maintenant
                            @else
                                Déjà cotisé
                            @endif
                        </a>
                        <a href="{{ route('tontines.show', $tontine) }}" class="bg-cauri-gold/10 text-terre-marron px-4 py-3 rounded-xl hover:bg-cauri-gold/20 transition-colors">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-2xl p-8 border border-cauri-gold/20 text-center">
            <div class="text-6xl mb-4">🐚</div>
            <h3 class="text-xl font-sang-bleu font-bold text-terre-marron mb-2">Aucune tontine disponible</h3>
            <p class="text-terre-marron/70 mb-6">Vous devez être membre d'une tontine pour pouvoir cotiser.</p>
            <div class="flex gap-4 justify-center">
                <a href="{{ route('tontines.create') }}" class="bg-terre-marron text-ivoire px-6 py-3 rounded-xl hover:bg-terre-marron-dark transition-colors">
                    Créer une tontine
                </a>
                <a href="{{ route('tontines.index') }}" class="bg-cauri-gold text-terre-marron px-6 py-3 rounded-xl hover:bg-cauri-gold-light transition-colors">
                    Rejoindre une tontine
                </a>
            </div>
        </div>
    @endif
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