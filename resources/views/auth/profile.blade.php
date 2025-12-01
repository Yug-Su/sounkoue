@extends('layouts.app')

@section('title', 'Mon profil - Soun Kouê')
@section('page-title', 'Mon profil')
@section('page-description', 'Gérez vos informations personnelles')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Informations du profil -->
    <div class="bg-white rounded-2xl p-6 border border-cauri-gold/20">
        <div class="flex items-center gap-6 mb-6">
            <div class="w-20 h-20 bg-gradient-to-br from-terre-marron to-terre-marron-dark rounded-full flex items-center justify-center text-white text-2xl font-bold">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div>
                <h2 class="text-2xl font-sang-bleu font-bold text-terre-marron">{{ $user->name }}</h2>
                <p class="text-terre-marron/70">{{ $user->email }}</p>
                @if($user->phone)
                    <p class="text-terre-marron/70">{{ $user->phone }}</p>
                @endif
                <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                    {{ ucfirst($user->status) }}
                </span>
            </div>
        </div>

        <!-- Statistiques rapides -->
        <div class="grid md:grid-cols-3 gap-4">
            <div class="bg-ivoire rounded-xl p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-cauri-gold/20 rounded-lg flex items-center justify-center">
                        <i data-lucide="users" class="w-5 h-5 text-cauri-gold"></i>
                    </div>
                    <div>
                        <p class="text-xs text-terre-marron/60">Tontines</p>
                        <p class="font-bold text-terre-marron">{{ $user->tontineMembers->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-ivoire rounded-xl p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="wallet" class="w-5 h-5 text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-terre-marron/60">Solde wallet</p>
                        <p class="font-bold text-terre-marron">{{ number_format($user->wallet_balance, 0, ',', ' ') }} FCFA</p>
                    </div>
                </div>
            </div>

            <div class="bg-ivoire rounded-xl p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i data-lucide="calendar" class="w-5 h-5 text-green-600"></i>
                    </div>
                    <div>
                        <p class="text-xs text-terre-marron/60">Membre depuis</p>
                        <p class="font-bold text-terre-marron">{{ $user->created_at->format('M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulaire de modification -->
    <div class="bg-white rounded-2xl p-6 border border-cauri-gold/20">
        <h3 class="text-lg font-sang-bleu font-bold text-terre-marron mb-6">Modifier mes informations</h3>

        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="name" class="text-terre-marron flex items-center gap-2 font-medium">
                        🐚
                        Nom complet
                    </label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        required
                        value="{{ old('name', $user->name) }}"
                        class="w-full border border-cauri-gold/30 focus:border-cauri-gold rounded-xl px-4 py-3 outline-none transition-colors"
                        placeholder="Votre nom complet"
                    />
                </div>

                <div class="space-y-2">
                    <label for="email" class="text-terre-marron flex items-center gap-2 font-medium">
                        🐚
                        Email
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        required
                        value="{{ old('email', $user->email) }}"
                        class="w-full border border-cauri-gold/30 focus:border-cauri-gold rounded-xl px-4 py-3 outline-none transition-colors"
                        placeholder="votre@email.com"
                    />
                </div>
            </div>

            <div class="space-y-2">
                <label for="phone" class="text-terre-marron flex items-center gap-2 font-medium">
                    🐚
                    Numéro de téléphone
                </label>
                <input
                    id="phone"
                    name="phone"
                    type="tel"
                    value="{{ old('phone', $user->phone) }}"
                    class="w-full border border-cauri-gold/30 focus:border-cauri-gold rounded-xl px-4 py-3 outline-none transition-colors"
                    placeholder="+225 XX XX XX XX XX"
                />
            </div>

            <hr class="border-cauri-gold/20">

            <div class="space-y-4">
                <h4 class="text-terre-marron font-medium">Changer le mot de passe (optionnel)</h4>
                
                <div class="space-y-2">
                    <label for="password" class="text-terre-marron flex items-center gap-2 font-medium">
                        🐚
                        Nouveau mot de passe
                    </label>
                    <div class="relative">
                        <input
                            id="password"
                            name="password"
                            type="password"
                            class="w-full border border-cauri-gold/30 focus:border-cauri-gold rounded-xl px-4 py-3 pr-10 outline-none transition-colors"
                            placeholder="Laissez vide pour ne pas changer"
                        />
                        <button
                            type="button"
                            onclick="togglePassword('password')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-terre-marron/50 hover:text-terre-marron"
                        >
                            <i data-lucide="eye" class="w-4 h-4" id="password-eye-icon"></i>
                        </button>
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="password_confirmation" class="text-terre-marron flex items-center gap-2 font-medium">
                        🐚
                        Confirmer le nouveau mot de passe
                    </label>
                    <div class="relative">
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            class="w-full border border-cauri-gold/30 focus:border-cauri-gold rounded-xl px-4 py-3 pr-10 outline-none transition-colors"
                            placeholder="Confirmez votre nouveau mot de passe"
                        />
                        <button
                            type="button"
                            onclick="togglePassword('password_confirmation')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-terre-marron/50 hover:text-terre-marron"
                        >
                            <i data-lucide="eye" class="w-4 h-4" id="password_confirmation-eye-icon"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex gap-4">
                <button
                    type="submit"
                    class="bg-gradient-to-r from-terre-marron to-terre-marron-dark text-ivoire px-6 py-3 rounded-xl hover:opacity-90 transition-opacity font-medium"
                >
                    Mettre à jour le profil
                </button>
                <a
                    href="{{ route('dashboard') }}"
                    class="border border-cauri-gold text-terre-marron px-6 py-3 rounded-xl hover:bg-cauri-gold/10 transition-colors font-medium"
                >
                    Annuler
                </a>
            </div>
        </form>
    </div>

    <!-- Activité récente -->
    <div class="bg-white rounded-2xl p-6 border border-cauri-gold/20">
        <h3 class="text-lg font-sang-bleu font-bold text-terre-marron mb-6">Activité récente</h3>
        
        <div class="space-y-4">
            @forelse($user->tontineMembers->take(5) as $membership)
                <div class="flex items-center justify-between p-4 bg-ivoire rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-cauri-gold/20 rounded-lg flex items-center justify-center">
                            <i data-lucide="users" class="w-5 h-5 text-cauri-gold"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-terre-marron">{{ $membership->tontine->name }}</h4>
                            <p class="text-sm text-terre-marron/60">Rejoint le {{ $membership->joined_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                        {{ ucfirst($membership->status) }}
                    </span>
                </div>
            @empty
                <p class="text-center text-terre-marron/60 py-8">Aucune activité récente</p>
            @endforelse
        </div>
    </div>
</div>

<script>
    function togglePassword(fieldId) {
        const passwordInput = document.getElementById(fieldId);
        const eyeIcon = document.getElementById(fieldId + '-eye-icon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.setAttribute('data-lucide', 'eye-off');
        } else {
            passwordInput.type = 'password';
            eyeIcon.setAttribute('data-lucide', 'eye');
        }
        lucide.createIcons();
    }
</script>
@endsection