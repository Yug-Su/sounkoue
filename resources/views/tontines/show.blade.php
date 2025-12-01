@extends('layouts.app')

@section('title', $tontine->name . ' - Soun Kouê')
@section('page-title', $tontine->name)
@section('page-description', 'Détails et gestion de votre tontine')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 sm:py-8">
<div class="space-y-4 sm:space-y-6">
    <!-- Header avec actions -->
    <div class="bg-white rounded-2xl p-4 sm:p-6 border border-cauri-gold/20">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 mb-2">
                    <h1 class="text-xl sm:text-2xl font-sang-bleu font-bold text-terre-marron">{{ $tontine->name }}</h1>
                    <span class="px-2 sm:px-3 py-1 rounded-full text-xs font-medium self-start
                        @if($tontine->status === 'active') bg-green-100 text-green-800
                        @elseif($tontine->status === 'pending') bg-yellow-100 text-yellow-800
                        @elseif($tontine->status === 'completed') bg-blue-100 text-blue-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        @if($tontine->status === 'active') Actif
                        @elseif($tontine->status === 'pending') En attente
                        @elseif($tontine->status === 'completed') Terminé
                        @else {{ ucfirst($tontine->status) }}
                        @endif
                    </span>
                </div>
                @if($tontine->description)
                    <p class="text-sm sm:text-base text-terre-marron/70">{{ $tontine->description }}</p>
                @endif
                <p class="text-xs sm:text-sm text-terre-marron/60 mt-1">
                    Créé par {{ $tontine->creator->name }} le {{ $tontine->created_at->format('d/m/Y') }}
                </p>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-2">
                @if($tontine->creator_id === auth()->id())
                    @if($canContribute)
                        <a href="{{ route('payments.form', $tontine) }}" class="bg-cauri-gold text-terre-marron px-3 sm:px-4 py-2 rounded-lg hover:bg-cauri-gold-light transition-colors text-sm flex items-center gap-2 justify-center animate-hammer">
                            <i data-lucide="credit-card" class="w-4 h-4"></i>
                            Cotiser
                        </a>
                    @else
                        <button disabled class="bg-gray-300 text-gray-500 px-3 sm:px-4 py-2 rounded-lg text-sm flex items-center gap-2 justify-center cursor-not-allowed">
                            <i data-lucide="check" class="w-4 h-4"></i>
                            Déjà cotisé
                        </button>
                    @endif
                    @if($tontine->status === 'pending')
                        <form method="POST" action="{{ route('tontines.start', $tontine) }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-3 sm:px-4 py-2 rounded-lg hover:bg-green-700 transition-colors text-sm">
                                <span class="hidden sm:inline">Démarrer la tontine</span>
                                <span class="sm:hidden">Démarrer</span>
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('tontines.edit', $tontine) }}" class="bg-terre-marron text-ivoire px-3 sm:px-4 py-2 rounded-lg hover:bg-terre-marron-dark transition-colors text-sm text-center">
                        Modifier
                    </a>
                @else
                    @php
                        $isMember = $tontine->members->where('user_id', auth()->id())->first();
                    @endphp
                    
                    @if($isMember)
                        <div class="flex gap-2">
                            @if($canContribute)
                                <a href="{{ route('payments.form', $tontine) }}" class="bg-cauri-gold text-terre-marron px-3 sm:px-4 py-2 rounded-lg hover:bg-cauri-gold-light transition-colors text-sm flex items-center gap-2 animate-hammer">
                                    <i data-lucide="credit-card" class="w-4 h-4"></i>
                                    Cotiser
                                </a>
                            @else
                                <button disabled class="bg-gray-300 text-gray-500 px-3 sm:px-4 py-2 rounded-lg text-sm flex items-center gap-2 cursor-not-allowed">
                                    <i data-lucide="check" class="w-4 h-4"></i>
                                    Déjà cotisé
                                </button>
                            @endif
                            @if($tontine->status === 'pending')
                                <form method="DELETE" action="{{ route('tontines.leave', $tontine) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-3 sm:px-4 py-2 rounded-lg hover:bg-red-700 transition-colors text-sm">
                                        Quitter
                                    </button>
                                </form>
                            @endif
                        </div>
                    @elseif($tontine->status === 'pending')
                        <button onclick="openJoinModal()" class="bg-terre-marron text-ivoire px-3 sm:px-4 py-2 rounded-lg hover:bg-terre-marron-dark transition-colors text-sm flex items-center gap-2">
                            <i data-lucide="user-plus" class="w-4 h-4"></i>
                            Rejoindre
                        </button>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-4 sm:gap-6">
        <!-- Informations principales -->
        <div class="lg:col-span-2 space-y-4 sm:space-y-6">
            <!-- Statistiques -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-xl p-3 sm:p-4 border border-cauri-gold/20">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-cauri-gold/10 rounded-lg flex items-center justify-center">
                            <i data-lucide="dollar-sign" class="w-4 h-4 sm:w-5 sm:h-5 text-cauri-gold"></i>
                        </div>
                        <div>
                            <p class="text-xs text-terre-marron/60">Cotisation</p>
                            <p class="font-bold text-terre-marron text-sm sm:text-base">{{ number_format($tontine->amount_per_contribution, 0, ',', ' ') }} FCFA</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-3 sm:p-4 border border-cauri-gold/20">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="users" class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-terre-marron/60">Membres</p>
                            <p class="font-bold text-terre-marron text-sm sm:text-base">{{ $tontine->members->count() }}/{{ $tontine->max_members }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-3 sm:p-4 border border-cauri-gold/20 sm:col-span-2 md:col-span-1">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i data-lucide="repeat" class="w-4 h-4 sm:w-5 sm:h-5 text-purple-600"></i>
                        </div>
                        <div>
                            <p class="text-xs text-terre-marron/60">Fréquence</p>
                            <p class="font-bold text-terre-marron text-sm sm:text-base">
                                @if($tontine->frequency === 'weekly') Hebdo
                                @elseif($tontine->frequency === 'biweekly') Bimensuel
                                @elseif($tontine->frequency === 'monthly') Mensuel
                                @elseif($tontine->frequency === 'quarterly') Trimestriel
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Membres -->
            <div class="bg-white rounded-2xl p-4 sm:p-6 border border-cauri-gold/20">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-2">
                    <h3 class="text-base sm:text-lg font-sang-bleu font-bold text-terre-marron">Membres ({{ $tontine->members->count() }})</h3>
                    @if($tontine->creator_id === auth()->id() && $tontine->status === 'pending')
                        <button class="text-cauri-gold hover:text-cauri-gold-light text-xs sm:text-sm flex items-center gap-1 self-start">
                            <i data-lucide="user-plus" class="w-3 h-3 sm:w-4 sm:h-4"></i>
                            <span class="hidden sm:inline">Inviter</span>
                        </button>
                    @endif
                </div>

                @if($tontine->members->count() > 0)
                    <div class="space-y-3">
                        @foreach($tontine->members as $member)
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between p-3 bg-ivoire rounded-xl gap-2">
                                <div class="flex items-center gap-2 sm:gap-3">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-terre-marron to-terre-marron-dark rounded-full flex items-center justify-center text-white font-bold text-sm">
                                        {{ substr($member->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-terre-marron text-sm sm:text-base">{{ $member->user->name }}</h4>
                                        <p class="text-xs sm:text-sm text-terre-marron/60">
                                            Position: {{ $member->position_in_rotation ?? 'Non définie' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1 sm:gap-2">
                                    @if($member->user_id === $tontine->creator_id)
                                        <span class="px-2 py-1 bg-cauri-gold/20 text-cauri-gold text-xs rounded-full">Créateur</span>
                                    @endif
                                    <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">{{ ucfirst($member->status) }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-terre-marron/60 py-8 text-sm">Aucun membre pour le moment</p>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-4 sm:space-y-6">
            <!-- Progression -->
            <div class="bg-white rounded-2xl p-4 sm:p-6 border border-cauri-gold/20">
                <h3 class="text-base sm:text-lg font-sang-bleu font-bold text-terre-marron mb-4">Progression</h3>
                
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-xs sm:text-sm text-terre-marron/60 mb-1">
                            <span>Membres</span>
                            <span>{{ $tontine->members->count() }}/{{ $tontine->max_members }}</span>
                        </div>
                        <div class="w-full bg-cauri-gold/20 rounded-full h-2">
                            <div class="bg-cauri-gold h-2 rounded-full" style="width: {{ ($tontine->members->count() / $tontine->max_members) * 100 }}%"></div>
                        </div>
                    </div>

                    @if($tontine->status === 'active')
                        <div>
                            <div class="flex justify-between text-xs sm:text-sm text-terre-marron/60 mb-1">
                                <span>Tour actuel</span>
                                <span>{{ $tontine->current_round }}/{{ $tontine->members->count() }}</span>
                            </div>
                            <div class="w-full bg-blue-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($tontine->current_round / $tontine->members->count()) * 100 }}%"></div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @if($tontine->creator_id === auth()->id() && $tontine->invite_code)
                <!-- Lien d'invitation -->
                <div class="bg-white rounded-2xl p-4 sm:p-6 border border-cauri-gold/20">
                    <h3 class="text-base sm:text-lg font-sang-bleu font-bold text-terre-marron mb-4">Inviter des membres</h3>
                    
                    <div class="bg-ivoire rounded-xl p-4">
                        <label class="text-xs sm:text-sm text-terre-marron/70 block mb-2">Lien d'invitation</label>
                        <div class="flex gap-2">
                            <input id="inviteLink" type="text" readonly value="{{ route('tontines.join-by-code', $tontine->invite_code) }}" class="flex-1 min-w-0 bg-white border border-cauri-gold/30 rounded-lg px-2 sm:px-3 py-2 text-xs sm:text-sm" />
                            <button onclick="copyInviteLink()" class="flex-shrink-0 bg-terre-marron text-white px-2 sm:px-3 py-2 rounded-lg hover:bg-terre-marron-dark transition-colors">
                                <i data-lucide="copy" class="w-3 h-3 sm:w-4 sm:h-4"></i>
                            </button>
                        </div>
                        <div class="flex gap-2 mt-3">
                            <button onclick="shareInviteLink()" class="flex-1 bg-cauri-gold text-terre-marron px-3 sm:px-4 py-2 rounded-lg hover:bg-cauri-gold-light transition-colors text-xs sm:text-sm">
                                Partager
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Informations -->
            <div class="bg-white rounded-2xl p-4 sm:p-6 border border-cauri-gold/20">
                <h3 class="text-base sm:text-lg font-sang-bleu font-bold text-terre-marron mb-4">Informations</h3>
                
                <div class="space-y-3 text-xs sm:text-sm">
                    <div class="flex justify-between">
                        <span class="text-terre-marron/60">Ordre de rotation</span>
                        <span class="text-terre-marron font-medium">
                            @if($tontine->rotation_order === 'random') Aléatoire
                            @elseif($tontine->rotation_order === 'alphabetical') Alphabétique
                            @elseif($tontine->rotation_order === 'custom') Personnalisé
                            @endif
                        </span>
                    </div>
                    
                    @if($tontine->start_date)
                        <div class="flex justify-between">
                            <span class="text-terre-marron/60">Date de début</span>
                            <span class="text-terre-marron font-medium">{{ $tontine->start_date->format('d/m/Y') }}</span>
                        </div>
                    @endif
                    
                    <div class="flex justify-between">
                        <span class="text-terre-marron/60">Total par tour</span>
                        <span class="text-terre-marron font-medium">
                            {{ number_format($tontine->amount_per_contribution * $tontine->members->count(), 0, ',', ' ') }} FCFA
                        </span>
                    </div>
                </div>
            </div>

            @if($tontine->status === 'pending' && $tontine->members->count() >= 3 && $tontine->creator_id === auth()->id())
                <!-- Call to action -->
                <div class="bg-gradient-to-br from-cauri-gold to-cauri-gold-light rounded-2xl p-4 sm:p-6 text-terre-marron">
                    <h4 class="font-sang-bleu font-bold mb-2 text-sm sm:text-base">Prêt à démarrer ?</h4>
                    <p class="text-xs sm:text-sm mb-4 opacity-90">Vous avez suffisamment de membres pour commencer la tontine.</p>
                    <form method="POST" action="{{ route('tontines.start', $tontine) }}">
                        @csrf
                        <button type="submit" class="w-full bg-white/20 backdrop-blur-sm text-terre-marron py-2 rounded-lg hover:bg-white/30 transition-colors font-medium text-sm">
                            Démarrer maintenant
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
</div>

<!-- Modale de confirmation pour rejoindre -->
<div id="joinModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full relative overflow-hidden">
        <!-- Grid Background -->
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-br from-cauri-gold/10 via-ivoire to-terre-marron/5"></div>
            <div class="absolute inset-0" style="background-image: linear-gradient(rgba(111, 47, 47, 0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(111, 47, 47, 0.03) 1px, transparent 1px), linear-gradient(rgba(255, 189, 89, 0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 189, 89, 0.05) 1px, transparent 1px); background-size: 20px 20px, 20px 20px, 10px 10px, 10px 10px;"></div>
        </div>
        
        <div class="relative z-10 p-6 sm:p-8">
            <!-- Header -->
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-gradient-to-br from-cauri-gold to-cauri-gold-light rounded-full flex items-center justify-center mx-auto mb-4">
                    <div class="text-2xl text-terre-marron">🐚</div>
                </div>
                <h3 class="text-xl sm:text-2xl font-sang-bleu font-bold text-terre-marron mb-2">Rejoindre la tontine</h3>
                <p class="text-terre-marron/70 text-sm sm:text-base">Confirmez-vous vouloir rejoindre "{{ $tontine->name }}" ?</p>
            </div>
            
            <!-- Informations de la tontine -->
            <div class="bg-white/50 backdrop-blur-sm rounded-2xl p-4 mb-6 border border-cauri-gold/20">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-terre-marron/60 text-sm">Cotisation</span>
                        <span class="font-bold text-terre-marron">{{ number_format($tontine->amount_per_contribution, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-terre-marron/60 text-sm">Fréquence</span>
                        <span class="font-medium text-terre-marron">
                            @if($tontine->frequency === 'weekly') Hebdomadaire
                            @elseif($tontine->frequency === 'biweekly') Bimensuelle
                            @elseif($tontine->frequency === 'monthly') Mensuelle
                            @elseif($tontine->frequency === 'quarterly') Trimestrielle
                            @endif
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-terre-marron/60 text-sm">Places disponibles</span>
                        <span class="font-medium text-terre-marron">{{ $tontine->max_members - $tontine->members->count() }} restantes</span>
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-3">
                <button onclick="closeJoinModal()" class="flex-1 bg-gray-100 text-terre-marron px-4 py-3 rounded-xl hover:bg-gray-200 transition-colors font-medium">
                    Annuler
                </button>
                <form method="POST" action="{{ route('tontines.join', $tontine) }}" class="flex-1">
                    @csrf
                    <button type="submit" class="w-full bg-gradient-to-r from-terre-marron to-terre-marron-dark text-ivoire px-4 py-3 rounded-xl hover:opacity-90 transition-opacity font-bold flex items-center justify-center gap-2">
                        <i data-lucide="check" class="w-4 h-4"></i>
                        Confirmer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
@if(session('success') && str_contains(session('success'), 'Cotisation effectuée'))
<div id="successModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-3xl p-8 max-w-md mx-4 text-center">
        <div class="mb-6">
            <div class="w-20 h-20 bg-gradient-to-br from-cauri-gold to-cauri-gold-light rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-4xl">🎉</span>
            </div>
            <h3 class="text-2xl font-bold text-terre-marron mb-2">Félicitations !</h3>
            <p class="text-terre-marron/70">Vous avez bien fait votre cotisation de la journée</p>
        </div>
        
        <div class="bg-gradient-to-br from-cauri-gold/20 to-cauri-gold-light/20 rounded-2xl p-6 mb-6">
            <div class="text-6xl mb-4">🐚</div>
            <p class="text-terre-marron font-medium">Continuez sur cette lancée !</p>
            <p class="text-sm text-terre-marron/60 mt-2">Votre régularité fait la force de votre tontine</p>
        </div>
        
        <button onclick="closeSuccessModal()" class="w-full bg-gradient-to-r from-terre-marron to-terre-marron-dark text-ivoire rounded-xl py-3 font-bold hover:opacity-90 transition-opacity">
            Continuer
        </button>
    </div>
</div>
@endif

<script>
    function openJoinModal() {
        document.getElementById('joinModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    // Afficher automatiquement la modale si l'utilisateur vient d'un lien d'invitation
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success') && (str_contains(session('success'), 'rejoindre') || str_contains(session('success'), 'Connexion') || str_contains(session('success'), 'Compte')))
            setTimeout(function() {
                openJoinModal();
            }, 500);
        @endif
        
        @if(session('from_invite'))
            setTimeout(function() {
                openJoinModal();
            }, 500);
        @endif
        
        // Vérifier si l'URL contient un paramètre d'invitation
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('from_invite') || document.referrer.includes('/join/')) {
            setTimeout(function() {
                openJoinModal();
            }, 500);
        }
    });
    
    function closeJoinModal() {
        document.getElementById('joinModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    
    // Fermer la modale en cliquant sur l'overlay
    document.getElementById('joinModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeJoinModal();
        }
    });
    
    // Fermer la modale avec Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeJoinModal();
        }
    });

    function copyInviteLink() {
        const inviteLink = document.getElementById('inviteLink');
        inviteLink.select();
        document.execCommand('copy');
        
        // Show feedback
        const button = event.target.closest('button');
        const originalContent = button.innerHTML;
        button.innerHTML = '<i data-lucide="check" class="w-3 h-3 sm:w-4 sm:h-4"></i>';
        lucide.createIcons();
        
        setTimeout(() => {
            button.innerHTML = originalContent;
            lucide.createIcons();
        }, 2000);
    }
    
    function shareInviteLink() {
        const inviteLink = document.getElementById('inviteLink').value;
        
        if (navigator.share) {
            navigator.share({
                title: 'Rejoindre ma tontine',
                text: 'Rejoignez ma tontine sur Soun Kouê',
                url: inviteLink
            });
        } else {
            copyInviteLink();
        }
    }
    
    function closeSuccessModal() {
        document.getElementById('successModal').style.display = 'none';
    }
</script>

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
    0%, 100% { background-color: rgb(255, 189, 89); }
    50% { background-color: rgb(255, 200, 110); }
}

.animate-hammer {
    animation: hammer 1.5s ease-in-out infinite, pulse-glow 2s ease-in-out infinite;
    position: relative;
    z-index: 10;
}
</style>

<script>
</script>
@endsection