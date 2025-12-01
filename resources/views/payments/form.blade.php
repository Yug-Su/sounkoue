@extends('layouts.app')

@section('title', 'Cotisation - ' . $tontine->name)
@section('page-title', 'Effectuer une cotisation')
@section('page-description', 'Choisissez votre moyen de paiement')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 sm:py-8">
    <div class="grid md:grid-cols-2 gap-8">
        <!-- Left - Payment Form -->
        <div class="bg-white rounded-3xl p-6 sm:p-8">
            <form method="POST" action="{{ route('payments.process', $tontine) }}" class="space-y-6">
                @csrf
                
                <!-- Tontine Info -->
                <div class="bg-ivoire rounded-2xl p-6">
                    <div class="flex justify-between mb-3">
                        <span class="text-terre-marron/70">Tontine</span>
                        <span class="text-terre-marron">{{ $tontine->name }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-terre-marron/70">Montant à payer</span>
                        <div class="flex items-center gap-2">
                            <span class="text-2xl text-cauri-gold">🐚</span>
                            <span class="text-2xl font-bold text-terre-marron">{{ number_format($tontine->amount_per_contribution, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="space-y-4">
                    <label class="text-terre-marron font-medium">Moyen de paiement</label>
                    
                    <div class="space-y-3">
                        <label class="flex items-center space-x-3 border-2 rounded-xl p-4 cursor-pointer transition-all hover:border-cauri-gold/50" for="wallet">
                            <input type="radio" id="wallet" name="payment_method" value="wallet" checked class="text-cauri-gold" onchange="togglePaymentMethod()">
                            <div class="bg-gradient-to-br from-cauri-gold to-cauri-gold-light rounded-lg p-2">
                                <i data-lucide="wallet" class="w-5 h-5 text-terre-marron"></i>
                            </div>
                            <div class="flex-1">
                                <div class="text-terre-marron font-medium">Wallet Soun Kouê</div>
                                <div class="text-sm text-terre-marron/60">Solde: {{ number_format($wallet->balance, 0, ',', ' ') }} FCFA</div>
                            </div>
                        </label>

                        <label class="flex items-center space-x-3 border-2 rounded-xl p-4 cursor-pointer transition-all hover:border-cauri-gold/50" for="mobile">
                            <input type="radio" id="mobile" name="payment_method" value="mobile_money" class="text-cauri-gold" onchange="togglePaymentMethod()">
                            <div class="bg-gradient-to-br from-terre-marron to-terre-marron-dark rounded-lg p-2">
                                <i data-lucide="smartphone" class="w-5 h-5 text-cauri-gold"></i>
                            </div>
                            <div class="flex-1">
                                <div class="text-terre-marron font-medium">Mobile Money</div>
                                <div class="text-sm text-terre-marron/60">Orange Money, MTN, Moov</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Mobile Money Number -->
                <div id="mobileMoneyField" class="space-y-2 hidden">
                    <label for="phone_number" class="text-terre-marron font-medium">Numéro Mobile Money</label>
                    <input
                        id="phone_number"
                        name="phone_number"
                        type="tel"
                        class="w-full border border-cauri-gold/30 focus:border-cauri-gold rounded-xl px-3 py-3 outline-none transition-colors"
                        placeholder="+225 XX XX XX XX XX"
                    />
                </div>



                <button
                    type="submit"
                    id="payButton"
                    class="w-full bg-gradient-to-r from-terre-marron to-terre-marron-dark hover:opacity-90 text-ivoire rounded-xl py-4 sm:py-6 font-bold transition-opacity"
                >
                    Valider le paiement
                </button>
            </form>
        </div>

        <!-- Right - Payment Visual -->
        <div class="hidden md:block">
            <div class="bg-gradient-to-br from-cauri-gold to-cauri-gold-light rounded-3xl p-8">
                <div class="mb-8">
                    <div class="text-terre-marron/70 mb-2">Vous payez</div>
                    <div class="text-5xl font-bold text-terre-marron mb-4">{{ number_format($tontine->amount_per_contribution, 0, ',', ' ') }}</div>
                    <div class="text-terre-marron/70">FCFA</div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center gap-3 bg-white/30 backdrop-blur-sm rounded-xl p-4">
                        <div class="text-2xl text-terre-marron">🐚</div>
                        <div>
                            <div class="text-terre-marron/70 text-sm">Pour</div>
                            <div class="text-terre-marron font-medium">{{ $tontine->name }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
@if(session('success'))
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
    function togglePaymentMethod() {
        const mobileField = document.getElementById('mobileMoneyField');
        const mobileRadio = document.getElementById('mobile');
        const payButton = document.getElementById('payButton');
        
        if (mobileRadio.checked) {
            mobileField.classList.remove('hidden');
            payButton.textContent = 'Initier le paiement';
        } else {
            mobileField.classList.add('hidden');
            payButton.textContent = 'Valider le paiement';
        }
    }
    
    function closeSuccessModal() {
        document.getElementById('successModal').style.display = 'none';
    }


</script>
@endsection