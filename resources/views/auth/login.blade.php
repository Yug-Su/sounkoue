<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Soun Kouê</title>
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
        <div class="absolute inset-0 bg-gradient-to-br from-cauri-gold/20 via-ivoire to-terre-marron/10"></div>
        <div class="absolute inset-0" style="background-image: linear-gradient(rgba(111, 47, 47, 0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(111, 47, 47, 0.05) 1px, transparent 1px), linear-gradient(rgba(255, 189, 89, 0.08) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 189, 89, 0.08) 1px, transparent 1px); background-size: 30px 30px, 30px 30px, 15px 15px, 15px 15px;"></div>
    </div>
    
    <div class="w-full max-w-5xl grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 relative z-10">
        <!-- Left side - Form -->
        <div class="bg-white rounded-2xl md:rounded-3xl p-6 md:p-12">
            <a href="/" class="mb-4 md:mb-6 -ml-2 text-terre-marron hover:text-cauri-gold transition-colors flex items-center gap-2">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span class="text-sm md:text-base">Retour</span>
            </a>

            <div class="mb-6 md:mb-8">
                <h2 class="text-2xl md:text-3xl lg:text-4xl font-sang-bleu text-terre-marron mb-2">Bon retour !</h2>
                <p class="text-base md:text-lg text-terre-marron/70">Connectez-vous à votre compte Soun Kouê</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4 md:space-y-6">
                @csrf
                @if(session('tontine_to_join') || request('tontine_to_join'))
                    <input type="hidden" name="tontine_to_join" value="{{ session('tontine_to_join') ?? request('tontine_to_join') }}">
                @endif
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
                        placeholder="votre@email.com"
                    />
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
                            onclick="togglePassword()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-terre-marron/50 hover:text-terre-marron"
                        >
                            <i data-lucide="eye" class="w-4 h-4" id="eye-icon"></i>
                        </button>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-0">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-cauri-gold/30" />
                        <span class="text-xs md:text-sm text-terre-marron/70">Se souvenir de moi</span>
                    </label>
                    <button
                        type="button"
                        class="text-xs md:text-sm text-terre-marron hover:text-cauri-gold transition-colors text-left sm:text-right"
                    >
                        Mot de passe oublié ?
                    </button>
                </div>

                <button
                    type="submit"
                    class="w-full bg-terre-marron hover:bg-terre-marron-dark text-ivoire rounded-lg md:rounded-xl py-4 md:py-6 text-sm md:text-base font-bold transition-colors"
                >
                    Se connecter
                </button>

                <p class="text-center text-terre-marron/70 text-sm md:text-base">
                    Pas encore de compte ?
                    <a
                        href="{{ route('register') }}{{ session('tontine_to_join') ? '?tontine_to_join=' . session('tontine_to_join') : '' }}"
                        class="text-terre-marron hover:text-cauri-gold transition-colors ml-1"
                    >
                        S'inscrire
                    </a>
                </p>
            </form>
        </div>

        <!-- Right side - Illustration -->
        <div class="hidden md:flex flex-col justify-center items-center bg-gradient-to-br from-cauri-gold to-cauri-gold-light rounded-2xl md:rounded-3xl p-8 md:p-12 relative overflow-hidden">
            <!-- Modern Grid Background -->
            <div class="absolute inset-0">
                <div class="absolute inset-0" style="background-image: linear-gradient(rgba(111, 47, 47, 0.08) 1px, transparent 1px), linear-gradient(90deg, rgba(111, 47, 47, 0.08) 1px, transparent 1px), linear-gradient(rgba(255, 189, 89, 0.06) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 189, 89, 0.06) 1px, transparent 1px); background-size: 20px 20px, 20px 20px, 10px 10px, 10px 10px; background-position: -1px -1px, -1px -1px, -1px -1px, -1px -1px;"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-transparent via-white/10 to-transparent"></div>
            </div>
            
            <div class="relative z-10 text-center">
                <div class="mb-6 md:mb-8 flex justify-center">
                    <div class="relative">
                        <div class="bg-white rounded-full p-8 md:p-12">
                            <div class="text-6xl md:text-8xl text-terre-marron">🐚</div>
                        </div>
                    </div>
                </div>
                
                <h3 class="text-2xl md:text-3xl lg:text-4xl font-sang-bleu text-terre-marron mb-3 md:mb-4">Bienvenue sur Soun Kouê</h3>
                <p class="text-terre-marron/80 text-base md:text-lg max-w-md">
                    Gérez vos tontines facilement avec la confiance et la solidarité qui font la force de nos communautés
                </p>

                <div class="mt-8 md:mt-12 grid grid-cols-3 gap-3 md:gap-4">
                    <div class="bg-white/30 backdrop-blur-sm rounded-lg md:rounded-xl p-3 md:p-4 flex items-center justify-center">
                        <div class="text-xl md:text-2xl text-terre-marron">🐚</div>
                    </div>
                    <div class="bg-white/30 backdrop-blur-sm rounded-lg md:rounded-xl p-3 md:p-4 flex items-center justify-center">
                        <div class="text-xl md:text-2xl text-terre-marron">🐚</div>
                    </div>
                    <div class="bg-white/30 backdrop-blur-sm rounded-lg md:rounded-xl p-3 md:p-4 flex items-center justify-center">
                        <div class="text-xl md:text-2xl text-terre-marron">🐚</div>
                    </div>
                    <div class="bg-white/30 backdrop-blur-sm rounded-lg md:rounded-xl p-3 md:p-4 flex items-center justify-center">
                        <div class="text-xl md:text-2xl text-terre-marron">🐚</div>
                    </div>
                    <div class="bg-white/30 backdrop-blur-sm rounded-lg md:rounded-xl p-3 md:p-4 flex items-center justify-center">
                        <div class="text-xl md:text-2xl text-terre-marron">🐚</div>
                    </div>
                    <div class="bg-white/30 backdrop-blur-sm rounded-lg md:rounded-xl p-3 md:p-4 flex items-center justify-center">
                        <div class="text-xl md:text-2xl text-terre-marron">🐚</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.setAttribute('data-lucide', 'eye-off');
            } else {
                passwordInput.type = 'password';
                eyeIcon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }

        // Fonction de toggle password conservée pour l'UX
    </script>
</body>
</html>