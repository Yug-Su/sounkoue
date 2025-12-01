@extends('layouts.app')

@section('title', 'Créer une tontine - Soun Kouê')
@section('page-title', 'Créer une tontine')
@section('page-description')
    Configurez votre nouvelle tontine en quelques étapes
@endsection

@section('content')
<div class="max-w-6xl mx-auto px-6 py-8">
    <div class="grid md:grid-cols-2 gap-8">
        <!-- Left side - Form -->
        <div>
            <form method="POST" action="{{ route('tontines.store') }}" class="space-y-6" id="tontineForm">
                @csrf
                
                <!-- Step 1: Basic Information -->
                <div id="step1" class="space-y-6">
                    <div class="space-y-2">
                        <label for="name" class="text-terre-marron flex items-center gap-2 text-md-bold">
                            🐚
                            Nom de la tontine
                        </label>
                        <input
                            id="name"
                            name="name"
                            required
                            value="{{ old('name') }}"
                            class="w-full border border-cauri-gold/30 focus:border-cauri-gold rounded-xl px-4 py-3 outline-none transition-colors @error('name') border-red-500 @enderror"
                            placeholder="Ex: Famille Diallo"
                        />
                        @error('name')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="amount_per_contribution" class="text-terre-marron flex items-center gap-2 text-md-bold">
                            <i data-lucide="dollar-sign" class="w-4 h-4 text-cauri-gold"></i>
                            Montant par cotisation (FCFA)
                        </label>
                        <input
                            id="amount_per_contribution"
                            name="amount_per_contribution"
                            type="number"
                            required
                            value="{{ old('amount_per_contribution') }}"
                            class="w-full border border-cauri-gold/30 focus:border-cauri-gold rounded-xl px-4 py-3 outline-none transition-colors @error('amount_per_contribution') border-red-500 @enderror"
                            placeholder="50000"
                        />
                        @error('amount_per_contribution')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="frequency" class="text-terre-marron flex items-center gap-2 text-md-bold">
                            <i data-lucide="repeat" class="w-4 h-4 text-cauri-gold"></i>
                            Fréquence des cotisations
                        </label>
                        <select
                            id="frequency"
                            name="frequency"
                            required
                            class="w-full border border-cauri-gold/30 focus:border-cauri-gold rounded-xl px-4 py-3 outline-none transition-colors @error('frequency') border-red-500 @enderror"
                        >
                            <option value="daily" {{ old('frequency') == 'daily' ? 'selected' : '' }}>Journalier</option>
                            <option value="weekly" {{ old('frequency') == 'weekly' ? 'selected' : '' }}>Hebdomadaire</option>
                            <option value="biweekly" {{ old('frequency') == 'biweekly' ? 'selected' : '' }}>Bimensuel</option>
                            <option value="monthly" {{ old('frequency', 'monthly') == 'monthly' ? 'selected' : '' }}>Mensuel</option>
                            <option value="quarterly" {{ old('frequency') == 'quarterly' ? 'selected' : '' }}>Trimestriel</option>
                        </select>
                        @error('frequency')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="max_members" class="text-terre-marron flex items-center gap-2 text-md-bold">
                            <i data-lucide="users" class="w-4 h-4 text-cauri-gold"></i>
                            Nombre de membres
                        </label>
                        <input
                            id="max_members"
                            name="max_members"
                            type="number"
                            required
                            min="3"
                            max="50"
                            value="{{ old('max_members') }}"
                            class="w-full border border-cauri-gold/30 focus:border-cauri-gold rounded-xl px-4 py-3 outline-none transition-colors @error('max_members') border-red-500 @enderror"
                            placeholder="10"
                        />
                        <p class="text-sm text-terre-marron/60">
                            Minimum 3 membres, maximum 50
                        </p>
                        @error('max_members')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="rotation_order" class="text-terre-marron flex items-center gap-2 text-md-bold">
                            <i data-lucide="calendar" class="w-4 h-4 text-cauri-gold"></i>
                            Ordre de rotation
                        </label>
                        <select
                            id="rotation_order"
                            name="rotation_order"
                            required
                            class="w-full border border-cauri-gold/30 focus:border-cauri-gold rounded-xl px-4 py-3 outline-none transition-colors @error('rotation_order') border-red-500 @enderror"
                        >
                            <option value="random" {{ old('rotation_order', 'random') == 'random' ? 'selected' : '' }}>Aléatoire</option>
                            <option value="alphabetical" {{ old('rotation_order') == 'alphabetical' ? 'selected' : '' }}>Alphabétique</option>
                            <option value="custom" {{ old('rotation_order') == 'custom' ? 'selected' : '' }}>Personnalisé</option>
                        </select>
                        @error('rotation_order')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4">
                        <button
                            type="button"
                            onclick="showStep2()"
                            class="w-full bg-gradient-to-r from-terre-marron to-terre-marron-dark hover:opacity-90 text-ivoire rounded-xl py-6 text-md-bold transition-opacity"
                        >
                            Continuer
                        </button>
                    </div>
                </div>

                <!-- Step 2: Optional Details -->
                <div id="step2" class="space-y-6 hidden">
                    <div class="mb-6">
                        <div class="flex items-center gap-2 mb-4">
                            <button type="button" onclick="showStep1()" class="text-terre-marron hover:bg-cauri-gold/10 p-2 rounded-lg transition-colors">
                                <i data-lucide="arrow-left" class="w-5 h-5"></i>
                            </button>
                            <h3 class="text-lg font-sang-bleu text-terre-marron">Informations complémentaires (facultatif)</h3>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="description" class="text-terre-marron flex items-center gap-2 text-md-bold">
                            <i data-lucide="file-text" class="w-4 h-4 text-cauri-gold"></i>
                            Description de la tontine
                        </label>
                        <textarea
                            id="description"
                            name="description"
                            rows="4"
                            class="w-full border border-cauri-gold/30 focus:border-cauri-gold rounded-xl px-4 py-3 outline-none transition-colors @error('description') border-red-500 @enderror"
                            placeholder="Décrivez l'objectif de votre tontine, les règles spécifiques..."
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="start_date" class="text-terre-marron flex items-center gap-2 text-md-bold">
                            <i data-lucide="calendar-days" class="w-4 h-4 text-cauri-gold"></i>
                            Date de début (optionnel)
                        </label>
                        <input
                            id="start_date"
                            name="start_date"
                            type="date"
                            value="{{ old('start_date') }}"
                            min="{{ date('Y-m-d') }}"
                            class="w-full border border-cauri-gold/30 focus:border-cauri-gold rounded-xl px-4 py-3 outline-none transition-colors @error('start_date') border-red-500 @enderror"
                        />
                        <p class="text-sm text-terre-marron/60">
                            Si non spécifiée, la tontine démarrera dès que tous les membres auront rejoint
                        </p>
                        @error('start_date')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-terre-marron flex items-center gap-2 text-md-bold">
                            <i data-lucide="shield-check" class="w-4 h-4 text-cauri-gold"></i>
                            Options de sécurité
                        </label>
                        <div class="space-y-3">
                            <label class="flex items-center gap-3">
                                <input
                                    type="checkbox"
                                    name="require_approval"
                                    value="1"
                                    {{ old('require_approval') ? 'checked' : '' }}
                                    class="w-4 h-4 text-terre-marron border-cauri-gold/30 rounded focus:ring-terre-marron"
                                />
                                <span class="text-sm text-terre-marron">Approuver manuellement les nouveaux membres</span>
                            </label>
                            <label class="flex items-center gap-3">
                                <input
                                    type="checkbox"
                                    name="is_private"
                                    value="1"
                                    {{ old('is_private') ? 'checked' : '' }}
                                    class="w-4 h-4 text-terre-marron border-cauri-gold/30 rounded focus:ring-terre-marron"
                                />
                                <span class="text-sm text-terre-marron">Tontine privée (invitation uniquement)</span>
                            </label>
                        </div>
                    </div>

                    <div class="pt-4 space-y-3">
                        <button
                            type="submit"
                            class="w-full bg-gradient-to-r from-terre-marron to-terre-marron-dark hover:opacity-90 text-ivoire rounded-xl py-6 text-md-bold transition-opacity"
                        >
                            Créer ma tontine
                        </button>
                        <button
                            type="button"
                            onclick="showStep1()"
                            class="w-full border border-terre-marron text-terre-marron hover:bg-terre-marron/10 rounded-xl py-3 text-md-bold transition-colors"
                        >
                            Retour
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Right side - Illustration and Info -->
        <div class="hidden md:block">
            <div class="sticky top-64">
                <div class="bg-gradient-to-br from-cauri-gold to-cauri-gold-light rounded-3xl p-8 shadow-xl relative overflow-hidden mb-6">
                    <!-- Pattern Background -->
                    <div class="absolute inset-0 opacity-10">
                        <div class="absolute inset-0" style="background-image: repeating-linear-gradient(60deg, transparent, transparent 15px, rgba(111, 47, 47, 0.1) 15px, rgba(111, 47, 47, 0.1) 30px);"></div>
                    </div>
                    
                    <div class="relative z-10">
                        <div class="mb-6 flex justify-center">
                            <div class="relative w-48 h-48">
                                <!-- Circle pattern -->
                                <div class="absolute w-10 h-10 rounded-full bg-terre-marron flex items-center justify-center shadow-lg" style="left: 85%; top: 50%; transform: translate(-50%, -50%)">
                                    <i data-lucide="users" class="w-5 h-5 text-white"></i>
                                </div>
                                <div class="absolute w-10 h-10 rounded-full bg-terre-marron flex items-center justify-center shadow-lg" style="left: 67%; top: 15%; transform: translate(-50%, -50%)">
                                    <i data-lucide="users" class="w-5 h-5 text-white"></i>
                                </div>
                                <div class="absolute w-10 h-10 rounded-full bg-terre-marron flex items-center justify-center shadow-lg" style="left: 33%; top: 15%; transform: translate(-50%, -50%)">
                                    <i data-lucide="users" class="w-5 h-5 text-white"></i>
                                </div>
                                <div class="absolute w-10 h-10 rounded-full bg-terre-marron flex items-center justify-center shadow-lg" style="left: 15%; top: 50%; transform: translate(-50%, -50%)">
                                    <i data-lucide="users" class="w-5 h-5 text-white"></i>
                                </div>
                                <div class="absolute w-10 h-10 rounded-full bg-terre-marron flex items-center justify-center shadow-lg" style="left: 33%; top: 85%; transform: translate(-50%, -50%)">
                                    <i data-lucide="users" class="w-5 h-5 text-white"></i>
                                </div>
                                <div class="absolute w-10 h-10 rounded-full bg-terre-marron flex items-center justify-center shadow-lg" style="left: 67%; top: 85%; transform: translate(-50%, -50%)">
                                    <i data-lucide="users" class="w-5 h-5 text-white"></i>
                                </div>
                                
                                <!-- Center cauri -->
                                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                                    <div class="bg-white rounded-full p-4 shadow-xl">
                                        <div class="text-5xl text-terre-marron">🐚</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h3 class="text-xl-bold font-sang-bleu text-terre-marron text-center mb-3">
                            Comment ça marche ?
                        </h3>
                        <p class="text-terre-marron/80 text-center text-lg-medium">
                            Créez votre cercle de solidarité et gérez automatiquement les cotisations et les distributions
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-cauri-gold/20 shadow-sm">
                    <h4 class="text-lg font-sang-bleu text-terre-marron mb-4">Progression</h4>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3" id="step1-check">
                            <div class="w-6 h-6 rounded-full border-2 border-cauri-gold flex items-center justify-center transition-colors" id="step1-icon">
                                <i data-lucide="check" class="w-4 h-4 text-terre-marron hidden"></i>
                            </div>
                            <div>
                                <h5 class="text-sm font-medium text-terre-marron">Informations de base</h5>
                                <p class="text-xs text-terre-marron/60">Nom, montant, fréquence</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3" id="step2-check">
                            <div class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center transition-colors" id="step2-icon">
                                <i data-lucide="check" class="w-4 h-4 text-terre-marron hidden"></i>
                            </div>
                            <div>
                                <h5 class="text-sm font-medium text-gray-400">Détails optionnels</h5>
                                <p class="text-xs text-gray-400">Description, paramètres</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3" id="step3-check">
                            <div class="w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center transition-colors" id="step3-icon">
                                <i data-lucide="check" class="w-4 h-4 text-terre-marron hidden"></i>
                            </div>
                            <div>
                                <h5 class="text-sm font-medium text-gray-400">Création terminée</h5>
                                <p class="text-xs text-gray-400">Tontine prête</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-8 max-w-md w-full shadow-2xl">
        <div class="text-center">
            <div class="text-6xl mb-4">🎉</div>
            <h3 class="text-2xl font-sang-bleu font-bold text-terre-marron mb-2">Félicitations !</h3>
            <p class="text-terre-marron/70 mb-6">Votre tontine a été créée avec succès. Vous pouvez maintenant inviter les membres à rejoindre.</p>
            
            <div class="bg-ivoire rounded-xl p-4 mb-6">
                <label class="text-sm text-terre-marron/70 block mb-2">Lien d'invitation</label>
                <div class="flex gap-2">
                    <input id="inviteLink" type="text" readonly class="flex-1 bg-white border border-cauri-gold/30 rounded-lg px-3 py-2 text-sm" />
                    <button onclick="copyInviteLink()" class="bg-terre-marron text-white px-4 py-2 rounded-lg hover:bg-terre-marron-dark transition-colors">
                        <i data-lucide="copy" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
            
            <div class="flex gap-3">
                <button onclick="shareInviteLink()" class="flex-1 bg-cauri-gold text-terre-marron px-4 py-3 rounded-xl hover:bg-cauri-gold-light transition-colors">
                    Partager
                </button>
                <button onclick="closeModal()" class="flex-1 bg-terre-marron text-white px-4 py-3 rounded-xl hover:bg-terre-marron-dark transition-colors">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function updateStepValidation() {
        const requiredFields = ['name', 'amount_per_contribution', 'frequency', 'max_members', 'rotation_order'];
        let isValid = true;
        
        requiredFields.forEach(field => {
            const input = document.getElementById(field);
            if (!input || !input.value.trim()) {
                isValid = false;
            }
        });
        
        const step1Icon = document.getElementById('step1-icon');
        const step1Check = document.getElementById('step1-check');
        
        if (!step1Icon || !step1Check) return;
        
        if (isValid) {
            step1Icon.classList.remove('border-cauri-gold');
            step1Icon.classList.add('bg-green-500', 'border-green-500');
            const icon = step1Icon.querySelector('i');
            if (icon) {
                icon.classList.remove('hidden', 'text-terre-marron');
                icon.classList.add('text-white');
                lucide.createIcons();
            }
            const h5 = step1Check.querySelector('h5');
            const p = step1Check.querySelector('p');
            if (h5) {
                h5.classList.remove('text-terre-marron');
                h5.classList.add('text-green-600');
            }
            if (p) {
                p.classList.remove('text-terre-marron/60');
                p.classList.add('text-green-500');
            }
        } else {
            step1Icon.classList.add('border-cauri-gold');
            step1Icon.classList.remove('bg-green-500', 'border-green-500');
            const icon = step1Icon.querySelector('i');
            if (icon) {
                icon.classList.add('hidden');
            }
            const h5 = step1Check.querySelector('h5');
            const p = step1Check.querySelector('p');
            if (h5) {
                h5.classList.add('text-terre-marron');
                h5.classList.remove('text-green-600');
            }
            if (p) {
                p.classList.add('text-terre-marron/60');
                p.classList.remove('text-green-500');
            }
        }
    }

    function showStep2() {
        const requiredFields = ['name', 'amount_per_contribution', 'frequency', 'max_members', 'rotation_order'];
        let isValid = true;
        
        requiredFields.forEach(field => {
            const input = document.getElementById(field);
            if (!input.value.trim()) {
                input.classList.add('border-red-500');
                isValid = false;
            } else {
                input.classList.remove('border-red-500');
            }
        });
        
        if (isValid) {
            document.getElementById('step1').classList.add('hidden');
            document.getElementById('step2').classList.remove('hidden');
            
            // Update step 2 validation
            const step2Icon = document.getElementById('step2-icon');
            const step2Check = document.getElementById('step2-check');
            step2Icon.classList.remove('border-gray-300');
            step2Icon.classList.add('bg-green-500', 'border-green-500');
            const step2IconElement = step2Icon.querySelector('i');
            if (step2IconElement) {
                step2IconElement.classList.remove('hidden', 'text-terre-marron');
                step2IconElement.classList.add('text-white');
                lucide.createIcons();
            }
            const step2H5 = step2Check.querySelector('h5');
            const step2P = step2Check.querySelector('p');
            if (step2H5) {
                step2H5.classList.remove('text-gray-400');
                step2H5.classList.add('text-green-600');
            }
            if (step2P) {
                step2P.classList.remove('text-gray-400');
                step2P.classList.add('text-green-500');
            }
        }
    }
    
    function showStep1() {
        document.getElementById('step2').classList.add('hidden');
        document.getElementById('step1').classList.remove('hidden');
        
        // Reset step 2 validation
        const step2Icon = document.getElementById('step2-icon');
        const step2Check = document.getElementById('step2-check');
        step2Icon.classList.add('border-gray-300');
        step2Icon.classList.remove('bg-green-500', 'border-green-500');
        const step2IconElement = step2Icon.querySelector('i');
        if (step2IconElement) {
            step2IconElement.classList.add('hidden');
            step2IconElement.classList.remove('text-white');
            step2IconElement.classList.add('text-terre-marron');
        }
        const step2H5 = step2Check.querySelector('h5');
        const step2P = step2Check.querySelector('p');
        if (step2H5) {
            step2H5.classList.add('text-gray-400');
            step2H5.classList.remove('text-green-600');
        }
        if (step2P) {
            step2P.classList.add('text-gray-400');
            step2P.classList.remove('text-green-500');
        }
    }
    
    // Add event listeners for real-time validation
    document.addEventListener('DOMContentLoaded', function() {
        const requiredFields = ['name', 'amount_per_contribution', 'frequency', 'max_members', 'rotation_order'];
        requiredFields.forEach(field => {
            const input = document.getElementById(field);
            if (input) {
                input.addEventListener('input', updateStepValidation);
                input.addEventListener('change', updateStepValidation);
            }
        });
        
        // Form submission validation
        document.getElementById('tontineForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const step3Icon = document.getElementById('step3-icon');
            const step3Check = document.getElementById('step3-check');
            
            if (step3Icon && step3Check) {
                step3Icon.classList.remove('border-gray-300');
                step3Icon.classList.add('bg-green-500', 'border-green-500');
                const step3IconElement = step3Icon.querySelector('i');
                if (step3IconElement) {
                    step3IconElement.classList.remove('hidden', 'text-terre-marron');
                    step3IconElement.classList.add('text-white');
                }
                const step3H5 = step3Check.querySelector('h5');
                const step3P = step3Check.querySelector('p');
                if (step3H5) {
                    step3H5.classList.remove('text-gray-400');
                    step3H5.classList.add('text-green-600');
                }
                if (step3P) {
                    step3P.classList.remove('text-gray-400');
                    step3P.classList.add('text-green-500');
                }
                lucide.createIcons();
            }
            
            // Submit form via AJAX
            const formData = new FormData(this);
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('inviteLink').value = data.invite_link;
                    document.getElementById('successModal').classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
    
    function copyInviteLink() {
        const inviteLink = document.getElementById('inviteLink');
        inviteLink.select();
        document.execCommand('copy');
        
        // Show feedback
        const button = event.target.closest('button');
        const originalContent = button.innerHTML;
        button.innerHTML = '<i data-lucide="check" class="w-4 h-4"></i>';
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
    
    function closeModal() {
        document.getElementById('successModal').classList.add('hidden');
    }
</script>
@endsection