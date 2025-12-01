<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Soun Kouê - Plateforme de Tontines')</title>
    
    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#6f2f2f">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Soun Kouê">
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/icons/icon-192x192.png">
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
<body class="min-h-screen bg-ivoire font-poppins">
    @auth
        <!-- Mobile Menu Overlay -->
        <div id="mobileMenuOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden md:hidden" onclick="toggleMobileMenu()"></div>
        
        <!-- Mobile Menu -->
        <nav id="mobileMenu" class="fixed left-0 top-0 w-64 bg-white border-r border-cauri-gold/20 shadow-lg flex-col flex md:hidden min-h-screen z-50 transform -translate-x-full transition-transform duration-300">
            <!-- Logo -->
            <div class="p-6 border-b border-cauri-gold/20">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-cauri-gold rounded-full flex items-center justify-center">
                        <span class="text-terre-marron font-bold">S</span>
                    </div>
                    <span class="text-xl font-sang-bleu font-bold text-terre-marron">Soun Kouê</span>
                </div>
            </div>

            <!-- Navigation Items -->
            <div class="flex-1 p-4">
                <div class="space-y-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-terre-marron/70 hover:text-terre-marron hover:bg-cauri-gold/10 rounded-xl transition-colors {{ request()->routeIs('dashboard') ? 'bg-cauri-gold/10 text-terre-marron' : '' }}" onclick="toggleMobileMenu()">
                        <i data-lucide="home" class="w-5 h-5"></i>
                        <span>Tableau de bord</span>
                    </a>
                    <a href="{{ route('tontines.create') }}" class="flex items-center gap-3 px-4 py-3 text-terre-marron/70 hover:text-terre-marron hover:bg-cauri-gold/10 rounded-xl transition-colors {{ request()->routeIs('tontines.create') ? 'bg-cauri-gold/10 text-terre-marron' : '' }}" onclick="toggleMobileMenu()">
                        <i data-lucide="plus" class="w-5 h-5"></i>
                        <span>Créer une tontine</span>
                    </a>
                    <a href="{{ route('tontines.index') }}" class="flex items-center gap-3 px-4 py-3 text-terre-marron/70 hover:text-terre-marron hover:bg-cauri-gold/10 rounded-xl transition-colors {{ request()->routeIs('tontines.*') && !request()->routeIs('tontines.create') ? 'bg-cauri-gold/10 text-terre-marron' : '' }}" onclick="toggleMobileMenu()">
                        <i data-lucide="users" class="w-5 h-5"></i>
                        <span>Mes tontines</span>
                    </a>
                    <a href="{{ route('wallet.index') }}" class="flex items-center gap-3 px-4 py-3 text-terre-marron/70 hover:text-terre-marron hover:bg-cauri-gold/10 rounded-xl transition-colors {{ request()->routeIs('wallet.*') ? 'bg-cauri-gold/10 text-terre-marron' : '' }}" onclick="toggleMobileMenu()">
                        <i data-lucide="wallet" class="w-5 h-5"></i>
                        <span>Mon wallet</span>
                    </a>
                </div>
            </div>

            <!-- User Actions -->
            <div class="p-4 border-t border-cauri-gold/20">
                <div class="space-y-2">
                    <!-- PWA Install Button -->
                    <button id="pwa-install-mobile" class="hidden w-full flex items-center gap-3 px-4 py-3 text-cauri-gold hover:text-terre-marron hover:bg-cauri-gold/10 rounded-xl transition-colors">
                        <i data-lucide="download" class="w-5 h-5"></i>
                        <span>Installer l'app</span>
                    </button>
                    
                    <a href="{{ route('profile') }}" class="w-full flex items-center gap-3 px-4 py-3 text-terre-marron/70 hover:text-terre-marron hover:bg-cauri-gold/10 rounded-xl transition-colors" onclick="toggleMobileMenu()">
                        <i data-lucide="settings" class="w-5 h-5"></i>
                        <span>Paramètres</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-terre-marron/70 hover:text-terre-marron hover:bg-cauri-gold/10 rounded-xl transition-colors">
                            <i data-lucide="log-out" class="w-5 h-5"></i>
                            <span>Déconnexion</span>
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="flex">
            <!-- Sidebar -->
            <nav class="w-64 bg-white border-r border-cauri-gold/20 shadow-sm flex-col hidden md:flex min-h-screen">
                <!-- Logo -->
                <div class="p-6 border-b border-cauri-gold/20">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-cauri-gold rounded-full flex items-center justify-center">
                            <span class="text-terre-marron font-bold">S</span>
                        </div>
                        <span class="text-xl font-sang-bleu font-bold text-terre-marron">Soun Kouê</span>
                    </div>
                </div>

                <!-- Navigation Items -->
                <div class="flex-1 p-4">
                    <div class="space-y-2">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-terre-marron/70 hover:text-terre-marron hover:bg-cauri-gold/10 rounded-xl transition-colors {{ request()->routeIs('dashboard') ? 'bg-cauri-gold/10 text-terre-marron' : '' }}">
                            <i data-lucide="home" class="w-5 h-5"></i>
                            <span>Tableau de bord</span>
                        </a>
                        <a href="{{ route('tontines.create') }}" class="flex items-center gap-3 px-4 py-3 text-terre-marron/70 hover:text-terre-marron hover:bg-cauri-gold/10 rounded-xl transition-colors {{ request()->routeIs('tontines.create') ? 'bg-cauri-gold/10 text-terre-marron' : '' }}">
                            <i data-lucide="plus" class="w-5 h-5"></i>
                            <span>Créer une tontine</span>
                        </a>
                        <a href="{{ route('tontines.index') }}" class="flex items-center gap-3 px-4 py-3 text-terre-marron/70 hover:text-terre-marron hover:bg-cauri-gold/10 rounded-xl transition-colors {{ request()->routeIs('tontines.*') && !request()->routeIs('tontines.create') ? 'bg-cauri-gold/10 text-terre-marron' : '' }}">
                            <i data-lucide="users" class="w-5 h-5"></i>
                            <span>Mes tontines</span>
                        </a>
                        <a href="{{ route('wallet.index') }}" class="flex items-center gap-3 px-4 py-3 text-terre-marron/70 hover:text-terre-marron hover:bg-cauri-gold/10 rounded-xl transition-colors {{ request()->routeIs('wallet.*') ? 'bg-cauri-gold/10 text-terre-marron' : '' }}">
                            <i data-lucide="wallet" class="w-5 h-5"></i>
                            <span>Mon wallet</span>
                        </a>
                    </div>
                </div>

                <!-- User Actions -->
                <div class="p-4 border-t border-cauri-gold/20">
                    <div class="space-y-2">
                        <!-- PWA Install Button -->
                        <button id="pwa-install-desktop" class="hidden w-full flex items-center gap-3 px-4 py-3 text-cauri-gold hover:text-terre-marron hover:bg-cauri-gold/10 rounded-xl transition-colors">
                            <i data-lucide="download" class="w-5 h-5"></i>
                            <span>Installer l'app</span>
                        </button>
                        
                        <a href="{{ route('profile') }}" class="w-full flex items-center gap-3 px-4 py-3 text-terre-marron/70 hover:text-terre-marron hover:bg-cauri-gold/10 rounded-xl transition-colors">
                            <i data-lucide="settings" class="w-5 h-5"></i>
                            <span>Paramètres</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-terre-marron/70 hover:text-terre-marron hover:bg-cauri-gold/10 rounded-xl transition-colors">
                                <i data-lucide="log-out" class="w-5 h-5"></i>
                                <span>Déconnexion</span>
                            </button>
                        </form>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="flex-1">
                <!-- Header -->
                <header class="bg-white border-b border-cauri-gold/20 px-4 md:px-6 py-4">
                    <div class="max-w-6xl mx-auto flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <!-- Mobile Menu Button -->
                            <button onclick="toggleMobileMenu()" class="md:hidden text-terre-marron hover:bg-cauri-gold/10 p-2 rounded-lg transition-colors">
                                <i data-lucide="menu" class="w-6 h-6" id="mobileMenuIcon"></i>
                            </button>
                            <div>
                                <h1 class="text-xl md:text-2xl font-sang-bleu font-bold text-terre-marron">@yield('page-title', 'Dashboard')</h1>
                                <p class="text-terre-marron/70 text-sm md:text-base hidden sm:block">@yield('page-description', 'Bienvenue sur votre espace Soun Kouê')</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 md:gap-4">
                            <button class="relative text-terre-marron hover:bg-cauri-gold/10 p-2 rounded-lg transition-colors">
                                <i data-lucide="bell" class="w-5 h-5"></i>
                                <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full"></span>
                            </button>
                            <button class="hidden sm:block text-terre-marron hover:bg-cauri-gold/10 p-2 rounded-lg transition-colors">
                                <i data-lucide="search" class="w-5 h-5"></i>
                            </button>
                            <div class="relative">
                                <button onclick="toggleUserMenu()" class="flex items-center gap-2 md:gap-3 bg-cauri-gold/10 px-2 md:px-4 py-2 rounded-xl hover:bg-cauri-gold/20 transition-colors">
                                    <div class="w-8 h-8 bg-gradient-to-br from-terre-marron to-terre-marron-dark rounded-full flex items-center justify-center text-white text-sm font-bold">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    <div class="hidden sm:block">
                                        <div class="text-sm font-medium text-terre-marron">{{ auth()->user()->name }}</div>
                                        <div class="text-xs text-terre-marron/60">Membre actif</div>
                                    </div>
                                    <i data-lucide="chevron-down" class="w-4 h-4 text-terre-marron transition-transform" id="userMenuIcon"></i>
                                </button>
                                
                                <!-- User Menu Dropdown -->
                                <div id="userMenu" class="hidden absolute right-0 top-full mt-2 w-56 bg-white rounded-xl shadow-lg border border-cauri-gold/20 py-2 z-50">
                                    <div class="px-4 py-3 border-b border-cauri-gold/10">
                                        <div class="text-sm font-medium text-terre-marron">{{ auth()->user()->name }}</div>
                                        <div class="text-xs text-terre-marron/60">{{ auth()->user()->email }}</div>
                                    </div>
                                    <div class="py-1">
                                        <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-2 text-terre-marron/70 hover:text-terre-marron hover:bg-cauri-gold/10 transition-colors">
                                            <i data-lucide="user" class="w-4 h-4"></i>
                                            <span>Mon profil</span>
                                        </a>
                                        <a href="{{ route('wallet.index') }}" class="flex items-center gap-3 px-4 py-2 text-terre-marron/70 hover:text-terre-marron hover:bg-cauri-gold/10 transition-colors">
                                            <i data-lucide="wallet" class="w-4 h-4"></i>
                                            <span>Mon wallet</span>
                                        </a>
                                        <a href="{{ route('support.index') }}" class="flex items-center gap-3 px-4 py-2 text-terre-marron/70 hover:text-terre-marron hover:bg-cauri-gold/10 transition-colors">
                                            <i data-lucide="help-circle" class="w-4 h-4"></i>
                                            <span>Aide & Support</span>
                                        </a>
                                        <div class="border-t border-cauri-gold/10 mt-1 pt-1">
                                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="w-full flex items-center gap-3 px-4 py-2 text-red-600 hover:bg-red-50 transition-colors">
                                                <i data-lucide="log-out" class="w-4 h-4"></i>
                                                <span>Déconnexion</span>
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Content -->
                <div class="p-6">
                    @if(session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl">
                            {{ session('error') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    @else
        @yield('content')
    @endauth

    <script>
        lucide.createIcons();

        // User menu toggle
        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            const icon = document.getElementById('userMenuIcon');
            
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            } else {
                menu.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
            }
        }
        
        function closeUserMenu() {
            const menu = document.getElementById('userMenu');
            const icon = document.getElementById('userMenuIcon');
            menu.classList.add('hidden');
            icon.style.transform = 'rotate(0deg)';
        }

        // Mobile menu toggle
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            const overlay = document.getElementById('mobileMenuOverlay');
            const icon = document.getElementById('mobileMenuIcon');
            
            if (menu.classList.contains('-translate-x-full')) {
                menu.classList.remove('-translate-x-full');
                menu.classList.add('translate-x-0');
                overlay.classList.remove('hidden');
                icon.setAttribute('data-lucide', 'x');
            } else {
                menu.classList.add('-translate-x-full');
                menu.classList.remove('translate-x-0');
                overlay.classList.add('hidden');
                icon.setAttribute('data-lucide', 'menu');
            }
            lucide.createIcons();
        }

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('userMenu');
            const button = event.target.closest('button[onclick="toggleUserMenu()"]');
            
            if (!button && !menu.contains(event.target)) {
                menu.classList.add('hidden');
                document.getElementById('userMenuIcon').style.transform = 'rotate(0deg)';
            }
        });

        // PWA Installation
        let deferredPrompt;
        const installButtonMobile = document.getElementById('pwa-install-mobile');
        const installButtonDesktop = document.getElementById('pwa-install-desktop');

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            
            // Check if already installed
            if (!window.matchMedia('(display-mode: standalone)').matches) {
                installButtonMobile.classList.remove('hidden');
                installButtonDesktop.classList.remove('hidden');
            }
        });

        function installPWA() {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        installButtonMobile.classList.add('hidden');
                        installButtonDesktop.classList.add('hidden');
                    }
                    deferredPrompt = null;
                });
            }
        }

        installButtonMobile.addEventListener('click', installPWA);
        installButtonDesktop.addEventListener('click', installPWA);

        // Register Service Worker
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js')
                    .then(function(registration) {
                        console.log('SW registered: ', registration);
                    })
                    .catch(function(registrationError) {
                        console.log('SW registration failed: ', registrationError);
                    });
            });
        }
    </script>
</body>
</html>