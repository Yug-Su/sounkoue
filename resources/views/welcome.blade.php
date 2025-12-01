<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soun Kouê - La tontine digitale</title>
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
                    fontSize: {
                        'display-xxs': ['1.5rem', { lineHeight: '2rem', fontWeight: '700' }],
                        'display-xs': ['1.875rem', { lineHeight: '2.25rem', fontWeight: '700' }],
                        'display-sm': ['2.25rem', { lineHeight: '2.5rem', fontWeight: '700' }],
                        'display-md': ['3rem', { lineHeight: '3.5rem', fontWeight: '700' }],
                        'display-lg': ['3.75rem', { lineHeight: '4.25rem', fontWeight: '700' }],
                        'display-xl': ['4.5rem', { lineHeight: '5rem', fontWeight: '700' }],
                        'xl-bold': ['1.25rem', { lineHeight: '1.75rem', fontWeight: '700' }],
                        'lg-medium': ['1.125rem', { lineHeight: '1.75rem', fontWeight: '500' }],
                        'md-bold': ['1rem', { lineHeight: '1.5rem', fontWeight: '700' }],
                        'md-semibold': ['1rem', { lineHeight: '1.5rem', fontWeight: '600' }],
                    },
                }
            }
        }
    </script>
</head>
<body class="bg-ivoire font-poppins min-h-screen">
    <!-- Header -->
    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-cauri-gold/20">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-cauri-gold rounded-full flex items-center justify-center">
                    <span class="text-terre-marron font-bold">S</span>
                </div>
                <span class="text-xl font-sang-bleu font-bold text-terre-marron">Soun Kouê</span>
            </div>
            <div class="flex gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 text-terre-marron hover:bg-cauri-gold/10 rounded-lg transition-colors">
                        Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-terre-marron hover:bg-cauri-gold/10 rounded-lg transition-colors">
                            Déconnexion
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-terre-marron hover:bg-cauri-gold/10 rounded-lg transition-colors">
                        Se connecter
                    </a>
                    <a href="{{ route('register') }}" class="hidden md:block px-4 py-2 bg-terre-marron hover:bg-terre-marron-dark text-ivoire rounded-lg transition-colors">
                        S'inscrire
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative overflow-hidden py-20 md:py-32">
        <!-- Modern Grid Background -->
        <div class="absolute inset-0">
            <div class="absolute inset-0" style="background-image: linear-gradient(rgba(111, 47, 47, 0.06) 1px, transparent 1px), linear-gradient(90deg, rgba(111, 47, 47, 0.06) 1px, transparent 1px), linear-gradient(rgba(255, 189, 89, 0.04) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 189, 89, 0.04) 1px, transparent 1px); background-size: 24px 24px, 24px 24px, 12px 12px, 12px 12px; background-position: -1px -1px, -1px -1px, -1px -1px, -1px -1px;"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-transparent via-cauri-gold/5 to-transparent"></div>
        </div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <div class="inline-flex items-center gap-2 bg-cauri-gold/20 px-4 py-2 rounded-full">
                        <div class="w-5 h-5 bg-terre-marron rounded-full"></div>
                        <span class="text-terre-marron">La fintech qui honore nos traditions</span>
                    </div>
                    <h1 class="text-display-lg font-sang-bleu text-terre-marron leading-tight">
                        La Tontine Digitale Inspirée de Nos Traditions
                    </h1>
                    <p class="text-xl text-terre-marron/80">
                        Gérez vos tontines en toute sécurité avec Soun Kouê. Automatisation, transparence et solidarité au cœur de notre plateforme.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        @guest
                            <a href="{{ route('register') }}" class="px-8 py-3 bg-gradient-to-r from-terre-marron to-terre-marron-dark hover:opacity-90 text-ivoire rounded-lg text-lg">
                                Commencer gratuitement
                            </a>
                            <a href="#how-it-works" class="px-8 py-3 border border-terre-marron text-terre-marron hover:bg-terre-marron/5 rounded-lg text-lg">
                                En savoir plus
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="px-8 py-3 bg-gradient-to-r from-terre-marron to-terre-marron-dark hover:opacity-90 text-ivoire rounded-lg text-lg">
                                Accéder au dashboard
                            </a>
                            <a href="{{ route('tontines.create') }}" class="px-8 py-3 border border-terre-marron text-terre-marron hover:bg-terre-marron/5 rounded-lg text-lg">
                                Créer une tontine
                            </a>
                        @endguest
                    </div>
                </div>
                
                <!-- Illustration -->
                <div class="relative">
                    <div class="relative z-10">
                        <div class="bg-gradient-to-br from-cauri-gold to-cauri-gold-light rounded-3xl p-6 md:p-12 shadow-2xl">
                            <div class="relative w-48 h-48 md:w-64 md:h-64 mx-auto">
                                <!-- Circle of people -->
                                <div class="absolute w-12 h-12 rounded-full bg-terre-marron flex items-center justify-center text-white shadow-lg" style="left: 90%; top: 50%; transform: translate(-50%, -50%)"><i data-lucide="users" class="w-6 h-6"></i></div>
                                <div class="absolute w-12 h-12 rounded-full bg-terre-marron flex items-center justify-center text-white shadow-lg" style="left: 75%; top: 13%; transform: translate(-50%, -50%)"><i data-lucide="users" class="w-6 h-6"></i></div>
                                <div class="absolute w-12 h-12 rounded-full bg-terre-marron flex items-center justify-center text-white shadow-lg" style="left: 25%; top: 13%; transform: translate(-50%, -50%)"><i data-lucide="users" class="w-6 h-6"></i></div>
                                <div class="absolute w-12 h-12 rounded-full bg-terre-marron flex items-center justify-center text-white shadow-lg" style="left: 10%; top: 50%; transform: translate(-50%, -50%)"><i data-lucide="users" class="w-6 h-6"></i></div>
                                <div class="absolute w-12 h-12 rounded-full bg-terre-marron flex items-center justify-center text-white shadow-lg" style="left: 25%; top: 87%; transform: translate(-50%, -50%)"><i data-lucide="users" class="w-6 h-6"></i></div>
                                <div class="absolute w-12 h-12 rounded-full bg-terre-marron flex items-center justify-center text-white shadow-lg" style="left: 75%; top: 87%; transform: translate(-50%, -50%)"><i data-lucide="users" class="w-6 h-6"></i></div>
                                
                                <!-- Center cauri -->
                                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                                    <div class="bg-white rounded-full p-6 shadow-xl">
                                        <div class="w-16 h-16 bg-terre-marron rounded-full flex items-center justify-center text-white text-2xl">🐚</div>
                                    </div>
                                </div>
                                
                                <!-- Connection lines -->
                                <svg class="absolute inset-0 w-full h-full">
                                    <line x1="50%" y1="50%" x2="90%" y2="50%" stroke="#6f2f2f" stroke-width="2" stroke-dasharray="5,5" opacity="0.3"/>
                                    <line x1="50%" y1="50%" x2="75%" y2="13%" stroke="#6f2f2f" stroke-width="2" stroke-dasharray="5,5" opacity="0.3"/>
                                    <line x1="50%" y1="50%" x2="25%" y2="13%" stroke="#6f2f2f" stroke-width="2" stroke-dasharray="5,5" opacity="0.3"/>
                                    <line x1="50%" y1="50%" x2="10%" y2="50%" stroke="#6f2f2f" stroke-width="2" stroke-dasharray="5,5" opacity="0.3"/>
                                    <line x1="50%" y1="50%" x2="25%" y2="87%" stroke="#6f2f2f" stroke-width="2" stroke-dasharray="5,5" opacity="0.3"/>
                                    <line x1="50%" y1="50%" x2="75%" y2="87%" stroke="#6f2f2f" stroke-width="2" stroke-dasharray="5,5" opacity="0.3"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Decorative elements -->
                    <div class="absolute -top-4 -right-4 w-24 h-24 bg-terre-marron rounded-full opacity-10 blur-2xl"></div>
                    <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-cauri-gold rounded-full opacity-10 blur-2xl"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-white relative">
        <!-- Modern Dot Grid -->
        <div class="absolute inset-0">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 1px 1px, rgba(111, 47, 47, 0.2) 1px, transparent 0); background-size: 12px 12px;"></div>
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 6px 6px, rgba(255, 189, 89, 0.15) 1px, transparent 0); background-size: 12px 12px;"></div>
            <div class="absolute inset-0 bg-gradient-to-tr from-white/80 via-transparent to-white/60"></div>
        </div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-display-xs md:text-display-sm font-sang-bleu text-terre-marron mb-4">
                    Ce que disent nos utilisateurs
                </h2>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-gradient-to-br from-ivoire to-white p-8 rounded-2xl shadow-lg border border-cauri-gold/20 hover:border-cauri-gold transition-all">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="text-5xl">👩🏾💼</div>
                        <div>
                            <div class="text-terre-marron font-semibold">Aminata K.</div>
                            <div class="text-terre-marron/60 text-sm">Commerçante</div>
                        </div>
                    </div>
                    <p class="text-terre-marron/80 italic">"Soun Kouê a transformé notre tontine familiale. Plus besoin de courir après les cotisations !"</p>
                </div>

                <div class="bg-gradient-to-br from-ivoire to-white p-8 rounded-2xl shadow-lg border border-cauri-gold/20 hover:border-cauri-gold transition-all">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="text-5xl">👨🏿💼</div>
                        <div>
                            <div class="text-terre-marron font-semibold">Moussa D.</div>
                            <div class="text-terre-marron/60 text-sm">Entrepreneur</div>
                        </div>
                    </div>
                    <p class="text-terre-marron/80 italic">"La transparence totale et l'automatisation font toute la différence. Je recommande vivement."</p>
                </div>

                <div class="bg-gradient-to-br from-ivoire to-white p-8 rounded-2xl shadow-lg border border-cauri-gold/20 hover:border-cauri-gold transition-all">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="text-5xl">👩🏾🏫</div>
                        <div>
                            <div class="text-terre-marron font-semibold">Fatoumata S.</div>
                            <div class="text-terre-marron/60 text-sm">Enseignante</div>
                        </div>
                    </div>
                    <p class="text-terre-marron/80 italic">"Simple, efficace et respectueux de nos traditions. Exactement ce dont nous avions besoin."</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-20 bg-ivoire relative overflow-hidden" id="how-it-works">
        <div class="absolute inset-0">
            <div class="absolute inset-0" style="background-image: linear-gradient(rgba(111, 47, 47, 0.04) 1px, transparent 1px), linear-gradient(90deg, rgba(111, 47, 47, 0.04) 1px, transparent 1px), linear-gradient(45deg, rgba(255, 189, 89, 0.06) 1px, transparent 1px), linear-gradient(-45deg, rgba(255, 189, 89, 0.06) 1px, transparent 1px); background-size: 20px 20px, 20px 20px, 14px 14px, 14px 14px;"></div>
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 20% 80%, rgba(255, 189, 89, 0.1) 2px, transparent 2px), radial-gradient(circle at 80% 20%, rgba(111, 47, 47, 0.08) 1px, transparent 1px); background-size: 40px 40px, 60px 60px;"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-ivoire/50 via-transparent to-ivoire/30"></div>
        </div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-display-xs md:text-display-sm font-sang-bleu text-terre-marron mb-4">
                    Comment ça marche ?
                </h2>
                <p class="text-xl text-terre-marron/70 max-w-2xl mx-auto">
                    Créez et gérez vos tontines en quelques clics
                </p>
            </div>

            <!-- Timeline Container -->
            <div class="relative max-w-6xl mx-auto">
                <!-- S-Curve SVG Path -->
                <svg class="absolute -right-64 w-1/2 h-full pointer-events-none z-0" viewBox="0 0 400 2000" preserveAspectRatio="none">
                    <path id="timeline-path" d="M 50 50 C 50 120, 150 180, 250 200 C 350 220, 380 280, 350 350 C 320 420, 220 440, 150 450 C 80 460, 20 520, 50 600 C 80 680, 180 700, 250 720 C 320 740, 380 800, 350 850 C 320 900, 220 920, 150 950 C 80 980, 20 1040, 50 1100 C 80 1160, 180 1180, 250 1200 C 320 1220, 380 1280, 350 1350 C 320 1420, 220 1440, 150 1450 C 80 1460, 20 1520, 50 1600 C 80 1680, 180 1700, 250 1720 C 320 1740, 380 1800, 350 1850 C 300 1900, 200 1920, 100 1950" 
                          stroke="#ffbd59" stroke-width="4" fill="none" stroke-dasharray="3000" stroke-dashoffset="3000" opacity="0.7"/>
                    <!-- Timeline dots -->
                    <circle class="timeline-dot" cx="50" cy="50" r="8" fill="#ffbd59" opacity="0"/>
                    <circle class="timeline-dot" cx="350" cy="250" r="8" fill="#ffbd59" opacity="0"/>
                    <circle class="timeline-dot" cx="50" cy="650" r="8" fill="#ffbd59" opacity="0"/>
                    <circle class="timeline-dot" cx="350" cy="1050" r="8" fill="#ffbd59" opacity="0"/>
                    <circle class="timeline-dot" cx="50" cy="1600" r="8" fill="#ffbd59" opacity="0"/>
                </svg>

                <!-- Timeline Steps -->
                <div class="relative md:space-y-20 space-y-10 z-10">
            <div class="bg-white flex md:flex-row flex-col justify-between items-center gap-8 py-10 md:px-12 px-4 shadow-sm rounded-3xl timeline-step" data-step="1">
                <div class="space-y-6 max-w-sm">
                    <div class="text-display-xs font-sang-bleu text-terre-marron">
                        Votre tontine personnalisée en 2 minutes.
                    </div>
                    <div class="text-lg-medium text-terre-marron/70">
                        Soun Kouê vous permet de créer plusieurs tontines adaptées à vos différents groupes. Choisissez les règles, ajoutez vos membres, et commencez à épargner ensemble.
                    </div>
                    <div class="flex md:gap-4">
                        <button class="bg-transparent border border-cauri-gold/50 text-terre-marron text-sm font-bold hover:bg-cauri-gold/10 transition-colors duration-300 rounded-sm hidden lg:block px-6 py-3">
                            Créer une tontine gratuite
                            <i data-lucide="arrow-right" class="w-4 h-4 text-cauri-gold ml-2 inline"></i>
                        </button>
                    </div>
                </div>
                <div class="md:w-[470px] w-[300px] h-[280px] md:h-[425px] bg-gradient-to-br from-cauri-gold/20 to-cauri-gold-light/20 rounded-3xl flex items-center justify-center">
                    <div class="text-6xl">👥</div>
                </div>
            </div>

            <div class="bg-white flex md:flex-row flex-col justify-between items-center gap-8 py-10 md:px-12 px-4 shadow-sm rounded-3xl timeline-step" data-step="2">
                <div class="space-y-6 max-w-sm">
                    <div class="text-display-xs font-sang-bleu text-terre-marron">
                        Cotisez partout, en plusieurs devises.
                    </div>
                    <div class="text-lg-medium text-terre-marron/70">
                        Avec Soun Kouê, vous n'avez pas à vous soucier des transactions. Nous acceptons tous les principaux moyens de paiement, locaux et internationaux. Vos gains seront livrés sous 72 heures.
                    </div>
                    <div class="flex md:gap-4">
                        <button class="bg-transparent border border-cauri-gold/50 text-terre-marron text-sm font-bold hover:bg-cauri-gold/10 transition-colors duration-300 rounded-sm hidden lg:block px-6 py-3">
                            Créer une tontine gratuite
                            <i data-lucide="arrow-right" class="w-4 h-4 text-cauri-gold ml-2 inline"></i>
                        </button>
                        <button class="bg-transparent text-terre-marron hover:underline px-0 py-3">
                            En savoir plus
                        </button>
                    </div>
                </div>
                <div class="md:w-[470px] w-[300px] h-[280px] md:h-[425px] bg-gradient-to-br from-cauri-gold/20 to-cauri-gold-light/20 rounded-3xl flex items-center justify-center">
                    <div class="text-6xl">💳</div>
                </div>
            </div>

            <div class="bg-white flex md:flex-row flex-col justify-between items-center gap-8 py-10 md:px-12 px-4 shadow-sm rounded-3xl timeline-step" data-step="3">
                <div class="space-y-6 max-w-sm">
                    <div class="text-display-xs font-sang-bleu text-terre-marron">
                        Connectez vos outils favoris.
                    </div>
                    <div class="text-lg-medium text-terre-marron/70">
                        Synchronisez facilement votre tontine avec vos outils de gestion préférés. Notifications, calendriers, applications bancaires—connectez-les tous pour optimiser votre épargne.
                    </div>
                    <div class="flex md:gap-4">
                        <button class="bg-transparent border border-cauri-gold/50 text-terre-marron text-sm font-bold hover:bg-cauri-gold/10 transition-colors duration-300 rounded-sm hidden lg:block px-6 py-3">
                            Créer une tontine gratuite
                            <i data-lucide="arrow-right" class="w-4 h-4 text-cauri-gold ml-2 inline"></i>
                        </button>
                        <button class="bg-transparent text-terre-marron hover:underline px-0 py-3">
                            En savoir plus
                        </button>
                    </div>
                </div>
                <div class="md:w-[470px] w-[300px] h-[280px] md:h-[425px] bg-gradient-to-br from-cauri-gold/20 to-cauri-gold-light/20 rounded-3xl flex items-center justify-center">
                    <div class="text-6xl">🔗</div>
                </div>
            </div>

            <div class="bg-white flex md:flex-row flex-col justify-between items-center gap-8 py-10 md:px-12 px-4 shadow-sm rounded-3xl timeline-step" data-step="4">
                <div class="space-y-6 max-w-sm">
                    <div class="text-display-xs font-sang-bleu text-terre-marron">
                        Suivez vos épargnes et ajustez votre stratégie.
                    </div>
                    <div class="text-lg-medium text-terre-marron/70">
                        Accédez à des analyses détaillées pour comprendre vos performances, identifier vos meilleures périodes d'épargne et optimiser vos contributions.
                    </div>
                    <div class="flex md:gap-4">
                        <button class="bg-transparent border border-cauri-gold/50 text-terre-marron text-sm font-bold hover:bg-cauri-gold/10 transition-colors duration-300 rounded-sm hidden lg:block px-6 py-3">
                            Créer une tontine gratuite
                            <i data-lucide="arrow-right" class="w-4 h-4 text-cauri-gold ml-2 inline"></i>
                        </button>
                    </div>
                </div>
                <div class="md:w-[470px] w-[300px] h-[280px] md:h-[425px] bg-gradient-to-br from-cauri-gold/20 to-cauri-gold-light/20 rounded-3xl flex items-center justify-center">
                    <div class="text-6xl">📊</div>
                </div>
            </div>

            <div class="bg-white flex md:flex-row flex-col justify-between items-center gap-8 py-10 md:px-12 px-4 shadow-sm rounded-3xl timeline-step" data-step="5">
                <div class="space-y-6 max-w-sm">
                    <div class="text-display-xs font-sang-bleu text-terre-marron">
                        Une équipe à vos côtés 24h/24 et 7j/7.
                    </div>
                    <div class="text-lg-medium text-terre-marron/70">
                        Nos experts sont là pour vous aider, que vous ayez besoin d'aide pour configurer votre tontine ou de conseils pour optimiser vos économies.
                    </div>
                    <div class="flex md:gap-4">
                        <button class="bg-transparent border border-cauri-gold/50 text-terre-marron text-sm font-bold hover:bg-cauri-gold/10 transition-colors duration-300 rounded-sm hidden lg:block px-6 py-3">
                            Créer une tontine gratuite
                            <i data-lucide="arrow-right" class="w-4 h-4 text-cauri-gold ml-2 inline"></i>
                        </button>
                    </div>
                </div>
                <div class="md:w-[470px] w-[300px] h-[280px] md:h-[425px] bg-gradient-to-br from-cauri-gold/20 to-cauri-gold-light/20 rounded-3xl flex items-center justify-center">
                    <div class="text-6xl">👥📞</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Key Features Section -->
    <section class="py-20 bg-gradient-to-br from-terre-marron to-terre-marron-dark text-white relative overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 50% 50%, rgba(255, 189, 89, 0.12) 1px, transparent 1px), linear-gradient(30deg, rgba(255, 189, 89, 0.06) 1px, transparent 1px), linear-gradient(150deg, rgba(255, 189, 89, 0.06) 1px, transparent 1px); background-size: 20px 20px, 10px 17px, 10px 17px;"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-terre-marron-dark/20 via-transparent to-terre-marron/10"></div>
        </div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-display-xs md:text-display-sm font-sang-bleu text-white mb-4">
                    Fonctionnalités clés
                </h2>
                <p class="text-lg-medium md:text-xl text-ivoire/80 max-w-2xl mx-auto">
                    Tout ce dont vous avez besoin pour gérer vos tontines
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white/10 backdrop-blur-sm p-6 rounded-2xl border border-cauri-gold/20">
                    <div class="mb-4">
                        <i data-lucide="shield" class="w-8 h-8 text-cauri-gold"></i>
                    </div>
                    <h3 class="text-xl-bold font-poppins text-white mb-2">Sécurité bancaire</h3>
                    <p class="text-ivoire/80 text-lg-medium">Cryptage de niveau bancaire et partenaires régulés</p>
                </div>

                <div class="bg-white/10 backdrop-blur-sm p-6 rounded-2xl border border-cauri-gold/20">
                    <div class="mb-4">
                        <i data-lucide="zap" class="w-8 h-8 text-cauri-gold"></i>
                    </div>
                    <h3 class="text-xl-bold font-poppins text-white mb-2">Automatisation</h3>
                    <p class="text-ivoire/80 text-lg-medium">Prélèvements et distributions automatiques</p>
                </div>

                <div class="bg-white/10 backdrop-blur-sm p-6 rounded-2xl border border-cauri-gold/20">
                    <div class="mb-4">
                        <i data-lucide="eye" class="w-8 h-8 text-cauri-gold"></i>
                    </div>
                    <h3 class="text-xl-bold font-poppins text-white mb-2">Transparence</h3>
                    <p class="text-ivoire/80 text-lg-medium">Suivi en temps réel de toutes les transactions</p>
                </div>

                <div class="bg-white/10 backdrop-blur-sm p-6 rounded-2xl border border-cauri-gold/20">
                    <div class="mb-4">
                        <i data-lucide="smartphone" class="w-8 h-8 text-cauri-gold"></i>
                    </div>
                    <h3 class="text-xl-bold font-poppins text-white mb-2">Application mobile</h3>
                    <p class="text-ivoire/80 text-lg-medium">Interface intuitive sur tous vos appareils</p>
                </div>

                <div class="bg-white/10 backdrop-blur-sm p-6 rounded-2xl border border-cauri-gold/20">
                    <div class="mb-4">
                        <i data-lucide="users" class="w-8 h-8 text-cauri-gold"></i>
                    </div>
                    <h3 class="text-xl-bold font-poppins text-white mb-2">Multi-groupes</h3>
                    <p class="text-ivoire/80 text-lg-medium">Participez à plusieurs tontines simultanément</p>
                </div>

                <div class="bg-white/10 backdrop-blur-sm p-6 rounded-2xl border border-cauri-gold/20">
                    <div class="mb-4">
                        <i data-lucide="headphones" class="w-8 h-8 text-cauri-gold"></i>
                    </div>
                    <h3 class="text-xl-bold font-poppins text-white mb-2">Support 24/7</h3>
                    <p class="text-ivoire/80 text-lg-medium">Assistance dédiée en français et langues locales</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Pricing Section -->
    <section class="py-20 bg-white relative">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-display-xs md:text-display-sm font-sang-bleu text-terre-marron mb-4">
                    Tarifs transparents
                </h2>
                <p class="text-xl text-terre-marron/70 max-w-2xl mx-auto">
                    Choisissez l'offre qui correspond à vos besoins
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <div class="bg-ivoire rounded-2xl p-8 border border-cauri-gold/20">
                    <h3 class="text-xl-bold font-sang-bleu text-terre-marron mb-4">Gratuit</h3>
                    <div class="text-4xl font-bold text-terre-marron mb-6">0€<span class="text-lg font-normal">/mois</span></div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-2">
                            <span class="text-cauri-gold">✓</span>
                            <span class="text-terre-marron/80">Jusqu'à 5 membres</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-cauri-gold">✓</span>
                            <span class="text-terre-marron/80">1 tontine active</span>
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="w-full py-3 border border-terre-marron text-terre-marron rounded-lg hover:bg-terre-marron/5 text-center block">
                        Commencer
                    </a>
                </div>

                <div class="bg-gradient-to-br from-cauri-gold to-cauri-gold-light rounded-2xl p-8 relative">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-terre-marron text-white px-4 py-1 rounded-full text-sm">
                        Populaire
                    </div>
                    <h3 class="text-xl-bold font-sang-bleu text-terre-marron mb-4">Premium</h3>
                    <div class="text-4xl font-bold text-terre-marron mb-6">9€<span class="text-lg font-normal">/mois</span></div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-2">
                            <span class="text-terre-marron">✓</span>
                            <span class="text-terre-marron/80">Jusqu'à 20 membres</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-terre-marron">✓</span>
                            <span class="text-terre-marron/80">Tontines illimitées</span>
                        </li>
                    </ul>
                    <a href="{{ route('register') }}" class="w-full py-3 bg-terre-marron text-white rounded-lg hover:bg-terre-marron-dark text-center block">
                        Choisir Premium
                    </a>
                </div>

                <div class="bg-ivoire rounded-2xl p-8 border border-cauri-gold/20">
                    <h3 class="text-xl-bold font-sang-bleu text-terre-marron mb-4">Entreprise</h3>
                    <div class="text-4xl font-bold text-terre-marron mb-6">Sur mesure</div>
                    <ul class="space-y-3 mb-8">
                        <li class="flex items-center gap-2">
                            <span class="text-cauri-gold">✓</span>
                            <span class="text-terre-marron/80">Membres illimités</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-cauri-gold">✓</span>
                            <span class="text-terre-marron/80">Support dédié</span>
                        </li>
                    </ul>
                    <button class="w-full py-3 border border-terre-marron text-terre-marron rounded-lg hover:bg-terre-marron/5">
                        Nous contacter
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-ivoire relative">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-display-xs md:text-display-sm font-sang-bleu text-terre-marron mb-4">
                    Questions fréquentes
                </h2>
            </div>

            <div class="max-w-3xl mx-auto space-y-4">
                <div class="bg-white rounded-2xl p-6 border border-cauri-gold/20">
                    <h3 class="text-lg-medium font-sang-bleu text-terre-marron mb-2">Qu'est-ce qu'une tontine digitale ?</h3>
                    <p class="text-terre-marron/80">Une tontine digitale reprend le principe traditionnel avec les avantages technologiques.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-cauri-gold/20">
                    <h3 class="text-lg-medium font-sang-bleu text-terre-marron mb-2">Mes fonds sont-ils sécurisés ?</h3>
                    <p class="text-terre-marron/80">Nous utilisons un cryptage bancaire et nos partenaires sont régulés.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-cauri-gold/20">
                    <h3 class="text-lg-medium font-sang-bleu text-terre-marron mb-2">Y a-t-il des frais cachés ?</h3>
                    <p class="text-terre-marron/80">Non, nos tarifs sont transparents. Seuls des frais bancaires peuvent s'appliquer.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-br from-cauri-gold to-cauri-gold-light relative overflow-hidden">
        <!-- Modern Diagonal Grid -->
        <div class="absolute inset-0">
            <div class="absolute inset-0" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 6px, rgba(111, 47, 47, 0.12) 6px, rgba(111, 47, 47, 0.12) 7px), repeating-linear-gradient(-45deg, transparent, transparent 6px, rgba(111, 47, 47, 0.08) 6px, rgba(111, 47, 47, 0.08) 7px);"></div>
            <div class="absolute inset-0 bg-gradient-to-bl from-cauri-gold-light/30 via-transparent to-cauri-gold/20"></div>
        </div>
        <div class="container mx-auto px-4 text-center relative z-10">
            <h2 class="text-display-xs md:text-display-sm font-sang-bleu text-terre-marron mb-6">
                Prêt à digitaliser votre tontine ?
            </h2>
            <p class="text-xl text-terre-marron/80 mb-8 max-w-2xl mx-auto">
                Rejoignez des milliers d'utilisateurs qui font confiance à Soun Kouê pour gérer leurs tontines
            </p>
            @guest
                <a href="{{ route('register') }}" class="px-12 py-3 bg-terre-marron hover:bg-terre-marron-dark text-ivoire rounded-lg text-lg transition-colors">
                    Commencer maintenant
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="px-12 py-3 bg-terre-marron hover:bg-terre-marron-dark text-ivoire rounded-lg text-lg transition-colors">
                    Accéder au dashboard
                </a>
            @endguest
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-terre-marron text-ivoire py-12">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-cauri-gold rounded-full flex items-center justify-center">
                            <span class="text-terre-marron font-bold">S</span>
                        </div>
                        <span class="text-xl-bold font-sang-bleu">Soun Kouê</span>
                    </div>
                    <p class="text-ivoire/70">
                        La tontine digitale inspirée de nos traditions
                    </p>
                </div>
                <div>
                    <h4 class="mb-4 font-sang-bleu font-bold">Produit</h4>
                    <ul class="space-y-2 text-ivoire/70">
                        <li><a href="#" class="hover:text-cauri-gold transition-colors">Fonctionnalités</a></li>
                        <li><a href="#" class="hover:text-cauri-gold transition-colors">Tarifs</a></li>
                        <li><a href="#" class="hover:text-cauri-gold transition-colors">Sécurité</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="mb-4 font-sang-bleu font-bold">Entreprise</h4>
                    <ul class="space-y-2 text-ivoire/70">
                        <li><a href="#" class="hover:text-cauri-gold transition-colors">À propos</a></li>
                        <li><a href="#" class="hover:text-cauri-gold transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-cauri-gold transition-colors">Carrières</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="mb-4 font-sang-bleu font-bold">Support</h4>
                    <ul class="space-y-2 text-ivoire/70">
                        <li><a href="#" class="hover:text-cauri-gold transition-colors">Centre d'aide</a></li>
                        <li><a href="#" class="hover:text-cauri-gold transition-colors">Contact</a></li>
                        <li><a href="#" class="hover:text-cauri-gold transition-colors">Mentions légales</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-ivoire/20 pt-8 text-center text-ivoire/60">
                <p>&copy; 2025 Soun Kouê. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script src="app.js"></script>
    <script>
        // Redirection rapide côté client pour les utilisateurs connectés
        @auth
        window.location.replace('{{ route('dashboard') }}');
        @endauth
        
        // Initialisation des icônes Lucide
        lucide.createIcons();

        // Timeline Animation
        const timelinePath = document.getElementById('timeline-path');
        const timelineSteps = document.querySelectorAll('.timeline-step');
        const timelineDots = document.querySelectorAll('.timeline-dot');
        const pathLength = timelinePath.getTotalLength();
        
        timelinePath.style.strokeDasharray = pathLength;
        timelinePath.style.strokeDashoffset = pathLength;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const step = parseInt(entry.target.dataset.step);
                    const progress = step / timelineSteps.length;
                    
                    // Animate path
                    timelinePath.style.strokeDashoffset = pathLength * (1 - progress);
                    
                    // Animate corresponding dot
                    if (timelineDots[step - 1]) {
                        timelineDots[step - 1].style.opacity = '1';
                        timelineDots[step - 1].style.transform = 'scale(1.2)';
                    }
                    
                    // Animate step
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.3 });

        timelineSteps.forEach(step => {
            step.style.transition = 'all 0.8s ease-out';
            step.style.opacity = '0.3';
            step.style.transform = 'translateY(20px)';
            observer.observe(step);
        });
        
        timelineDots.forEach(dot => {
            dot.style.transition = 'all 0.6s ease-out';
            dot.style.transformOrigin = 'center';
        });
        
        timelinePath.style.transition = 'stroke-dashoffset 1s ease-out';
    </script>
</body>
</html>