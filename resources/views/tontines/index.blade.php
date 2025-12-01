@extends('layouts.app')

@section('title', 'Mes tontines - Soun Kouê')
@section('page-title', 'Mes tontines')
@section('page-description', 'Gérez toutes vos tontines en un seul endroit')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 sm:py-8">
<div class="space-y-4 sm:space-y-6">
    <!-- Actions -->
    <div class="flex flex-col sm:flex-row gap-4 sm:justify-between sm:items-center">
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2 bg-white rounded-xl px-4 py-2 border border-cauri-gold/20 flex-1 sm:flex-none">
                <i data-lucide="search" class="w-4 h-4 text-terre-marron/60"></i>
                <input type="text" id="searchInput" placeholder="Rechercher..." class="outline-none bg-transparent text-terre-marron w-full">
            </div>
        </div>
        <a href="{{ route('tontines.create') }}" class="bg-gradient-to-r from-terre-marron to-terre-marron-dark text-ivoire px-4 sm:px-6 py-3 rounded-xl hover:opacity-90 transition-opacity flex items-center justify-center gap-2 text-sm sm:text-base">
            <i data-lucide="plus" class="w-4 h-4"></i>
            <span class="hidden sm:inline">Nouvelle tontine</span>
            <span class="sm:hidden">Créer</span>
        </a>
    </div>

    @if($tontines->count() > 0)
        <!-- Tontines Grid -->
        <div id="tontinesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($tontines as $tontine)
                <div class="bg-white rounded-2xl p-4 sm:p-6 border border-cauri-gold/20 hover:shadow-lg transition-shadow">
                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-4 gap-2">
                        <div class="flex-1">
                            <h3 class="text-base sm:text-lg font-sang-bleu font-bold text-terre-marron mb-1">{{ $tontine->name }}</h3>
                            <p class="text-xs sm:text-sm text-terre-marron/60">
                                Créé par {{ $tontine->creator->name }}
                            </p>
                        </div>
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

                    <!-- Stats -->
                    <div class="space-y-2 sm:space-y-3 mb-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs sm:text-sm text-terre-marron/60">Montant</span>
                            <span class="font-medium text-terre-marron text-xs sm:text-sm">{{ number_format($tontine->amount_per_contribution, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs sm:text-sm text-terre-marron/60">Membres</span>
                            <span class="font-medium text-terre-marron text-xs sm:text-sm">{{ $tontine->members->count() }}/{{ $tontine->max_members }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs sm:text-sm text-terre-marron/60">Fréquence</span>
                            <span class="font-medium text-terre-marron text-xs sm:text-sm">
                                @if($tontine->frequency === 'weekly') Hebdo
                                @elseif($tontine->frequency === 'biweekly') Bimensuel
                                @elseif($tontine->frequency === 'monthly') Mensuel
                                @elseif($tontine->frequency === 'quarterly') Trimestriel
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="flex justify-between text-xs text-terre-marron/60 mb-1">
                            <span>Progression</span>
                            <span>{{ round(($tontine->members->count() / $tontine->max_members) * 100) }}%</span>
                        </div>
                        <div class="w-full bg-cauri-gold/20 rounded-full h-2">
                            <div class="bg-cauri-gold h-2 rounded-full" style="width: {{ ($tontine->members->count() / $tontine->max_members) * 100 }}%"></div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-2">
                        <a href="{{ route('tontines.show', $tontine) }}" class="flex-1 bg-cauri-gold/10 text-terre-marron text-center py-2 rounded-lg hover:bg-cauri-gold/20 transition-colors text-xs sm:text-sm font-medium">
                            Voir détails
                        </a>
                        @if($tontine->creator_id === auth()->id() && $tontine->status === 'pending')
                            <form method="POST" action="{{ route('tontines.start', $tontine) }}" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full bg-terre-marron text-ivoire py-2 rounded-lg hover:bg-terre-marron-dark transition-colors text-xs sm:text-sm font-medium">
                                    Démarrer
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $tontines->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-8 sm:py-12 px-4">
            <div class="w-16 h-16 sm:w-24 sm:h-24 bg-cauri-gold/10 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="users" class="w-8 h-8 sm:w-12 sm:h-12 text-cauri-gold"></i>
            </div>
            <h3 class="text-lg sm:text-xl font-sang-bleu font-bold text-terre-marron mb-2">Aucune tontine pour le moment</h3>
            <p class="text-sm sm:text-base text-terre-marron/60 mb-6">Créez votre première tontine ou rejoignez un groupe existant</p>
            <div class="flex flex-col sm:flex-row justify-center gap-3 sm:gap-4">
                <a href="{{ route('tontines.create') }}" class="bg-terre-marron text-ivoire px-4 sm:px-6 py-3 rounded-xl hover:bg-terre-marron-dark transition-colors text-sm sm:text-base">
                    Créer une tontine
                </a>
                <button class="border border-cauri-gold text-terre-marron px-4 sm:px-6 py-3 rounded-xl hover:bg-cauri-gold/10 transition-colors text-sm sm:text-base">
                    Rejoindre un groupe
                </button>
            </div>
        </div>
    @endif
</div>
</div>
<script>
const searchInput = document.getElementById('searchInput');
const tontinesGrid = document.getElementById('tontinesGrid');

if (searchInput && tontinesGrid) {
    const allCards = Array.from(tontinesGrid.children);
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        
        allCards.forEach(card => {
            const title = card.querySelector('h3').textContent.toLowerCase();
            const creator = card.querySelector('p').textContent.toLowerCase();
            
            if (searchTerm === '' || title.includes(searchTerm) || creator.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
}
</script>
@endsection