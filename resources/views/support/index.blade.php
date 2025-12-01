@extends('layouts.app')

@section('title', 'Aide & Support - Soun Kouê')
@section('page-title', 'Aide & Support')
@section('page-description', 'Trouvez des réponses à vos questions et contactez notre équipe')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 sm:py-8">
    <!-- Section Contact Rapide -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 border border-cauri-gold/20 hover:shadow-lg transition-shadow">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-cauri-gold/10 rounded-xl flex items-center justify-center">
                    <i data-lucide="phone" class="w-6 h-6 text-terre-marron"></i>
                </div>
                <div>
                    <h3 class="font-sang-bleu font-bold text-terre-marron">Appelez-nous</h3>
                    <p class="text-sm text-terre-marron/70">Lun-Ven 8h-18h</p>
                </div>
            </div>
            <p class="text-terre-marron font-medium">+221 33 123 45 67</p>
        </div>

        <div class="bg-white rounded-xl p-6 border border-cauri-gold/20 hover:shadow-lg transition-shadow">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-cauri-gold/10 rounded-xl flex items-center justify-center">
                    <i data-lucide="mail" class="w-6 h-6 text-terre-marron"></i>
                </div>
                <div>
                    <h3 class="font-sang-bleu font-bold text-terre-marron">Email</h3>
                    <p class="text-sm text-terre-marron/70">Réponse sous 24h</p>
                </div>
            </div>
            <p class="text-terre-marron font-medium">support@sounkoue.com</p>
        </div>

        <div class="bg-white rounded-xl p-6 border border-cauri-gold/20 hover:shadow-lg transition-shadow">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-cauri-gold/10 rounded-xl flex items-center justify-center">
                    <i data-lucide="message-circle" class="w-6 h-6 text-terre-marron"></i>
                </div>
                <div>
                    <h3 class="font-sang-bleu font-bold text-terre-marron">Chat en direct</h3>
                    <p class="text-sm text-terre-marron/70">Disponible maintenant</p>
                </div>
            </div>
            <button class="text-cauri-gold hover:text-terre-marron font-medium transition-colors">Démarrer le chat</button>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="bg-white rounded-xl border border-cauri-gold/20 mb-8">
        <div class="p-6 border-b border-cauri-gold/10">
            <h2 class="text-xl font-sang-bleu font-bold text-terre-marron mb-2">Questions Fréquentes</h2>
            <p class="text-terre-marron/70">Trouvez rapidement des réponses aux questions les plus courantes</p>
        </div>
        
        <div class="p-6">
            <div class="space-y-4">
                <!-- FAQ Item 1 -->
                <div class="border border-cauri-gold/20 rounded-xl">
                    <button onclick="toggleFaq(1)" class="w-full flex items-center justify-between p-4 text-left hover:bg-cauri-gold/5 transition-colors">
                        <span class="font-medium text-terre-marron">Comment créer ma première tontine ?</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-terre-marron transition-transform" id="faq-icon-1"></i>
                    </button>
                    <div id="faq-content-1" class="hidden px-4 pb-4">
                        <p class="text-terre-marron/70">Pour créer votre première tontine, cliquez sur "Créer une tontine" dans le menu principal. Remplissez les informations requises : nom, montant, fréquence et nombre de participants. Une fois créée, vous pouvez inviter des membres via le code d'invitation.</p>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="border border-cauri-gold/20 rounded-xl">
                    <button onclick="toggleFaq(2)" class="w-full flex items-center justify-between p-4 text-left hover:bg-cauri-gold/5 transition-colors">
                        <span class="font-medium text-terre-marron">Comment recharger mon wallet ?</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-terre-marron transition-transform" id="faq-icon-2"></i>
                    </button>
                    <div id="faq-content-2" class="hidden px-4 pb-4">
                        <p class="text-terre-marron/70">Accédez à votre wallet depuis le menu principal, puis cliquez sur "Recharger". Vous pouvez utiliser Orange Money, Wave ou Free Money. Saisissez le montant et votre numéro de téléphone pour finaliser la transaction.</p>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="border border-cauri-gold/20 rounded-xl">
                    <button onclick="toggleFaq(3)" class="w-full flex items-center justify-between p-4 text-left hover:bg-cauri-gold/5 transition-colors">
                        <span class="font-medium text-terre-marron">Que faire si j'oublie de cotiser ?</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-terre-marron transition-transform" id="faq-icon-3"></i>
                    </button>
                    <div id="faq-content-3" class="hidden px-4 pb-4">
                        <p class="text-terre-marron/70">Si vous oubliez de cotiser à temps, vous recevrez des notifications de rappel. Vous pouvez rattraper votre cotisation dans les 48h suivant l'échéance. Au-delà, des pénalités peuvent s'appliquer selon les règles de votre tontine.</p>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="border border-cauri-gold/20 rounded-xl">
                    <button onclick="toggleFaq(4)" class="w-full flex items-center justify-between p-4 text-left hover:bg-cauri-gold/5 transition-colors">
                        <span class="font-medium text-terre-marron">Comment inviter des membres à ma tontine ?</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-terre-marron transition-transform" id="faq-icon-4"></i>
                    </button>
                    <div id="faq-content-4" class="hidden px-4 pb-4">
                        <p class="text-terre-marron/70">Chaque tontine dispose d'un code d'invitation unique. Partagez ce code avec vos proches ou utilisez le lien d'invitation direct. Les nouveaux membres peuvent rejoindre en saisissant le code ou en cliquant sur le lien.</p>
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div class="border border-cauri-gold/20 rounded-xl">
                    <button onclick="toggleFaq(5)" class="w-full flex items-center justify-between p-4 text-left hover:bg-cauri-gold/5 transition-colors">
                        <span class="font-medium text-terre-marron">Mes données sont-elles sécurisées ?</span>
                        <i data-lucide="chevron-down" class="w-5 h-5 text-terre-marron transition-transform" id="faq-icon-5"></i>
                    </button>
                    <div id="faq-content-5" class="hidden px-4 pb-4">
                        <p class="text-terre-marron/70">Oui, nous utilisons un chiffrement de niveau bancaire pour protéger vos données. Toutes les transactions sont sécurisées et nous ne stockons jamais vos informations de paiement. Vos données personnelles sont protégées selon les standards internationaux.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Guides et Tutoriels -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-xl border border-cauri-gold/20 p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-cauri-gold/10 rounded-lg flex items-center justify-center">
                    <i data-lucide="book-open" class="w-5 h-5 text-terre-marron"></i>
                </div>
                <h3 class="font-sang-bleu font-bold text-terre-marron">Guide du débutant</h3>
            </div>
            <p class="text-terre-marron/70 mb-4">Découvrez comment utiliser Soun Kouê étape par étape</p>
            <button class="text-cauri-gold hover:text-terre-marron font-medium transition-colors">Lire le guide →</button>
        </div>

        <div class="bg-white rounded-xl border border-cauri-gold/20 p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-cauri-gold/10 rounded-lg flex items-center justify-center">
                    <i data-lucide="play-circle" class="w-5 h-5 text-terre-marron"></i>
                </div>
                <h3 class="font-sang-bleu font-bold text-terre-marron">Tutoriels vidéo</h3>
            </div>
            <p class="text-terre-marron/70 mb-4">Regardez nos tutoriels pour maîtriser toutes les fonctionnalités</p>
            <button class="text-cauri-gold hover:text-terre-marron font-medium transition-colors">Voir les vidéos →</button>
        </div>
    </div>

    <!-- Formulaire de Contact -->
    <div class="bg-white rounded-xl border border-cauri-gold/20">
        <div class="p-6 border-b border-cauri-gold/10">
            <h2 class="text-xl font-sang-bleu font-bold text-terre-marron mb-2">Contactez-nous</h2>
            <p class="text-terre-marron/70">Vous n'avez pas trouvé la réponse à votre question ? Envoyez-nous un message</p>
        </div>
        
        <form class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-terre-marron mb-2">Nom complet</label>
                    <input type="text" class="w-full px-4 py-3 border border-cauri-gold/30 rounded-xl focus:outline-none focus:ring-2 focus:ring-cauri-gold focus:border-transparent bg-white" placeholder="Votre nom complet">
                </div>
                <div>
                    <label class="block text-sm font-medium text-terre-marron mb-2">Email</label>
                    <input type="email" class="w-full px-4 py-3 border border-cauri-gold/30 rounded-xl focus:outline-none focus:ring-2 focus:ring-cauri-gold focus:border-transparent bg-white" placeholder="votre@email.com">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-terre-marron mb-2">Sujet</label>
                <select class="w-full px-4 py-3 border border-cauri-gold/30 rounded-xl focus:outline-none focus:ring-2 focus:ring-cauri-gold focus:border-transparent bg-white">
                    <option>Problème technique</option>
                    <option>Question sur les tontines</option>
                    <option>Problème de paiement</option>
                    <option>Suggestion d'amélioration</option>
                    <option>Autre</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-terre-marron mb-2">Message</label>
                <textarea rows="5" class="w-full px-4 py-3 border border-cauri-gold/30 rounded-xl focus:outline-none focus:ring-2 focus:ring-cauri-gold focus:border-transparent bg-white resize-none" placeholder="Décrivez votre problème ou votre question en détail..."></textarea>
            </div>
            
            <button type="submit" class="w-full md:w-auto bg-gradient-to-r from-cauri-gold to-cauri-gold-light text-terre-marron font-medium px-8 py-3 rounded-xl hover:shadow-lg transition-all duration-200">
                Envoyer le message
            </button>
        </form>
    </div>
</div>

<script>
function toggleFaq(id) {
    const content = document.getElementById(`faq-content-${id}`);
    const icon = document.getElementById(`faq-icon-${id}`);
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
    } else {
        content.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}
</script>
@endsection