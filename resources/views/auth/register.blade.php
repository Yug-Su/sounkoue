<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Soun Kouê</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Crimson+Text:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'cauri-gold': '#ffbd59',
                        'terre-marron': '#6f2f2f',
                        'ivoire': '#fff1e7',
                        'cauri-gold-light': '#ffd68f',
                        'terre-marron-dark': '#4a1f1f',
                    },
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                        'sang-bleu': ['Crimson Text', 'serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-ivoire flex items-center justify-center p-4 font-poppins relative">
    <!-- Mobile Grid Background -->
    <div class="md:hidden absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-br from-terre-marron/15 via-ivoire to-cauri-gold/20"></div>
        <div class="absolute inset-0" style="background-image: linear-gradient(rgba(111, 47, 47, 0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(111, 47, 47, 0.05) 1px, transparent 1px), linear-gradient(rgba(255, 189, 89, 0.08) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 189, 89, 0.08) 1px, transparent 1px); background-size: 30px 30px, 30px 30px, 15px 15px, 15px 15px;"></div>
    </div>
    
    <div class="w-full max-w-6xl grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 relative z-10">
        <!-- Left side - Illustration -->
        <div class="hidden md:flex flex-col justify-center items-center bg-gradient-to-br from-terre-marron to-terre-marron-dark rounded-2xl md:rounded-3xl p-8 md:p-12 text-white relative overflow-hidden">
            <!-- Modern Grid Background -->
            <div class="absolute inset-0">
                <div class="absolute inset-0" style="background-image: linear-gradient(rgba(255, 189, 89, 0.08) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 189, 89, 0.08) 1px, transparent 1px), linear-gradient(rgba(111, 47, 47, 0.06) 1px, transparent 1px), linear-gradient(90deg, rgba(111, 47, 47, 0.06) 1px, transparent 1px); background-size: 20px 20px, 20px 20px, 10px 10px, 10px 10px; background-position: -1px -1px, -1px -1px, -1px -1px, -1px -1px;"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-transparent via-white/10 to-transparent"></div>
            </div>
            
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-6">
                    <div class="w-12 h-12 bg-cauri-gold rounded-full flex items-center justify-center">
                        <span class="text-terre-marron font-bold text-xl">S</span>
                    </div>
                    <span class="text-2xl font-sang-bleu font-bold">Soun Kouê</span>
                </div>
                
                <p class="text-xl mb-8 text-ivoire/90">
                    Rejoignez la communauté Soun Kouê et gérez vos tontines en toute sérénité
                </p>
                
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="text-2xl text-cauri-gold">🐚</div>
                        </div>
                        <div>
                            <h4 class="text-lg-medium mb-1">Inscription rapide</h4>
                            <p class="text-ivoire/70 text-sm">Créez votre compte en moins de 2 minutes</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="text-2xl text-cauri-gold">🐚</div>
                        </div>
                        <div>
                            <h4 class="text-lg-medium mb-1">Sécurité maximale</h4>
                            <p class="text-ivoire/70 text-sm">Vos données sont cryptées et protégées</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <div class="text-2xl text-cauri-gold">🐚</div>
                        </div>
                        <div>
                            <h4 class="text-lg-medium mb-1">Gratuit pour commencer</h4>
                            <p class="text-ivoire/70 text-sm">Aucun frais d'inscription</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right side - Form -->
        <div class="bg-white rounded-2xl md:rounded-3xl p-6 md:p-12 order-first md:order-last">
            <a href="/" class="mb-4 md:mb-6 -ml-2 text-terre-marron hover:text-cauri-gold transition-colors flex items-center gap-2">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span class="text-sm md:text-base">Retour</span>
            </a>

            <div class="mb-6 md:mb-8">
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-sang-bleu text-terre-marron mb-2">Créer un compte</h2>
                <p class="text-base md:text-lg text-terre-marron/70">Commencez votre aventure avec Soun Kouê</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4 md:space-y-6">
                @csrf
                @if(session('tontine_to_join') || request('tontine_to_join'))
                    <input type="hidden" name="tontine_to_join" value="{{ session('tontine_to_join') ?? request('tontine_to_join') }}">
                @endif
                <div class="space-y-2">
                    <label for="name" class="text-terre-marron flex items-center gap-2 text-sm md:text-base font-medium">
                        🐚
                        Nom complet
                    </label>
                    <input
                        id="name"
                        name="name"
                        required
                        value="{{ old('name') }}"
                        class="w-full border border-cauri-gold/30 focus:border-cauri-gold rounded-lg md:rounded-xl px-3 md:px-4 py-2 md:py-3 outline-none transition-colors text-sm md:text-base"
                        placeholder="Aminata Diallo"
                    />
                </div>

                <div class="space-y-2">
                    <label for="email" class="text-terre-marron flex items-center gap-2 text-sm md:text-base font-medium">
                        🐚
                        Email
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        required
                        value="{{ old('email') }}"
                        class="w-full border border-cauri-gold/30 focus:border-cauri-gold rounded-lg md:rounded-xl px-3 md:px-4 py-2 md:py-3 outline-none transition-colors text-sm md:text-base"
                        placeholder="aminata@email.com"
                    />
                </div>

                <div class="space-y-2">
                    <label for="phone" class="text-terre-marron flex items-center gap-2 text-sm md:text-base font-medium">
                        🐚
                        Numéro de téléphone (optionnel)
                    </label>
                    <div class="flex gap-1">
                        <select
                            id="country-code"
                            class="w-16 md:w-20 border border-cauri-gold/30 focus:border-cauri-gold rounded-lg md:rounded-xl px-1 py-2 md:py-3 outline-none transition-colors bg-white text-xs"
                        >
                            <option value="+225">🇨🇮 +225</option>
                            <option value="+33">🇫🇷 +33</option>
                            <option value="+1">🇺🇸 +1</option>
                            <option value="+221">🇸🇳 +221</option>
                            <option value="+226">🇧🇫 +226</option>
                            <option value="+223">🇲🇱 +223</option>
                            <option value="+229">🇧🇯 +229</option>
                            <option value="+228">🇹🇬 +228</option>
                        </select>
                        <input
                            id="phone"
                            name="phone"
                            type="tel"
                            value="{{ old('phone') }}"
                            class="flex-1 min-w-0 border border-cauri-gold/30 focus:border-cauri-gold rounded-lg md:rounded-xl px-3 py-2 md:py-3 outline-none transition-colors text-sm md:text-base"
                            placeholder="XX XX XX XX XX"
                        />
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="password" class="text-terre-marron flex items-center gap-2 text-sm md:text-base font-medium">
                        🐚
                        Mot de passe
                    </label>
                    <div class="relative">
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            class="w-full border border-cauri-gold/30 focus:border-cauri-gold rounded-lg md:rounded-xl px-3 md:px-4 py-2 md:py-3 pr-10 outline-none transition-colors text-sm md:text-base"
                            placeholder="••••••••"
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
                    <label for="password_confirmation" class="text-terre-marron flex items-center gap-2 text-sm md:text-base font-medium">
                        🐚
                        Confirmer le mot de passe
                    </label>
                    <div class="relative">
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            required
                            class="w-full border border-cauri-gold/30 focus:border-cauri-gold rounded-lg md:rounded-xl px-3 md:px-4 py-2 md:py-3 pr-10 outline-none transition-colors text-sm md:text-base"
                            placeholder="••••••••"
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

                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-terre-marron to-terre-marron-dark hover:opacity-90 text-ivoire rounded-lg md:rounded-xl py-4 md:py-6 text-sm md:text-base font-bold transition-opacity"
                >
                    Créer mon compte
                </button>

                <p class="text-center text-terre-marron/70 text-sm md:text-base">
                    Déjà un compte ?
                    <a
                        href="{{ route('login') }}{{ request('tontine_to_join') ? '?tontine_to_join=' . request('tontine_to_join') : '' }}"
                        class="text-terre-marron hover:text-cauri-gold transition-colors ml-1"
                    >
                        Se connecter
                    </a>
                </p>
            </form>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

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

        function formatPin(input) {
            // Only allow digits and limit to 4 characters
            input.value = input.value.replace(/\D/g, '').slice(0, 4);
        }

        // Fonctions de toggle password conservées pour l'UX
    </script>
</body>
</html>