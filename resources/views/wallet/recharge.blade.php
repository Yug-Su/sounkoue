@extends('layouts.app')

@section('title', 'Recharger le wallet - Soun Kouê')
@section('page-title', 'Recharger votre wallet')
@section('page-description', 'Ajoutez des fonds à votre wallet Soun Kouê')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 sm:py-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
        <!-- Left - Recharge Form -->
        <div class="bg-white rounded-2xl lg:rounded-3xl p-4 sm:p-6 lg:p-8">
            <form method="POST" action="{{ route('wallet.recharge.process') }}" class="space-y-4 sm:space-y-6">
                @csrf
                
                <!-- Wallet Info -->
                <div class="bg-ivoire rounded-xl lg:rounded-2xl p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:justify-between mb-3 gap-1 sm:gap-0">
                        <span class="text-terre-marron/70 text-sm sm:text-base">Solde actuel</span>
                        <span class="text-terre-marron font-medium text-sm sm:text-base">{{ number_format($wallet->balance, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 sm:gap-0">
                        <span class="text-terre-marron/70 text-sm sm:text-base">Montant à ajouter</span>
                        <div class="flex items-center gap-2 justify-end sm:justify-start">
                            <span class="text-xl sm:text-2xl text-cauri-gold">🐚</span>
                            <input type="number" name="amount" id="amount" min="100" step="100" required 
                                   class="text-base sm:text-lg lg:text-2xl font-bold text-terre-marron bg-white border-2 border-cauri-gold/30 focus:border-cauri-gold rounded-lg px-2 py-1 outline-none text-right w-24 sm:w-28 lg:w-36"
                                   placeholder="0" oninput="updateTotal()">
                            <span class="text-base sm:text-lg lg:text-xl text-terre-marron">FCFA</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="space-y-3 sm:space-y-4">
                    <label class="text-terre-marron font-medium text-sm sm:text-base">Moyen de paiement</label>
                    <div class="space-y-3">
                        <label class="flex items-center space-x-3 border-2 border-terre-marron rounded-xl p-3 sm:p-4">
                            <input type="radio" name="payment_method" value="mobile_money" checked class="text-cauri-gold">
                            <div class="bg-gradient-to-br from-terre-marron to-terre-marron-dark rounded-lg p-2">
                                <i data-lucide="smartphone" class="w-4 h-4 sm:w-5 sm:h-5 text-cauri-gold"></i>
                            </div>
                            <div class="flex-1">
                                <div class="text-terre-marron font-medium text-sm sm:text-base">Mobile Money</div>
                                <div class="text-xs sm:text-sm text-terre-marron/60">Orange Money, MTN, Moov</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Mobile Money Number -->
                <div class="space-y-2">
                    <label for="phone_number" class="text-terre-marron font-medium text-sm sm:text-base">Numéro Mobile Money</label>
                    <input
                        id="phone_number"
                        name="phone_number"
                        type="tel"
                        required
                        class="w-full border border-cauri-gold/30 focus:border-cauri-gold rounded-xl px-3 py-2 sm:py-3 outline-none transition-colors text-sm sm:text-base"
                        placeholder="+225 XX XX XX XX XX"
                    />
                </div>

                <!-- Amount Presets -->
                <div class="space-y-2">
                    <label class="text-terre-marron font-medium text-sm sm:text-base">Montants rapides</label>
                    <div class="grid grid-cols-3 gap-2">
                        <button type="button" onclick="setAmount(1000)" class="bg-cauri-gold/10 text-terre-marron px-2 sm:px-4 py-2 rounded-lg hover:bg-cauri-gold/20 transition-colors text-xs sm:text-sm">
                            1,000
                        </button>
                        <button type="button" onclick="setAmount(5000)" class="bg-cauri-gold/10 text-terre-marron px-2 sm:px-4 py-2 rounded-lg hover:bg-cauri-gold/20 transition-colors text-xs sm:text-sm">
                            5,000
                        </button>
                        <button type="button" onclick="setAmount(10000)" class="bg-cauri-gold/10 text-terre-marron px-2 sm:px-4 py-2 rounded-lg hover:bg-cauri-gold/20 transition-colors text-xs sm:text-sm">
                            10,000
                        </button>
                    </div>
                </div>



                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-terre-marron to-terre-marron-dark hover:opacity-90 text-ivoire rounded-xl py-3 sm:py-4 lg:py-6 font-bold transition-opacity text-sm sm:text-base"
                >
                    Initier la recharge
                </button>
            </form>
        </div>

        <!-- Right - Visual -->
        <div class="hidden lg:block">
            <div class="bg-gradient-to-br from-cauri-gold to-cauri-gold-light rounded-2xl lg:rounded-3xl p-4 sm:p-6 lg:p-8">
                <div class="mb-4 sm:mb-6 lg:mb-8">
                    <div class="text-terre-marron/70 mb-2 text-sm sm:text-base">Nouveau solde</div>
                    <div class="text-2xl sm:text-3xl lg:text-5xl font-bold text-terre-marron mb-2 lg:mb-4" id="newBalance">{{ number_format($wallet->balance, 0, ',', ' ') }}</div>
                    <div class="text-terre-marron/70 text-sm sm:text-base">FCFA</div>
                </div>
                <div class="space-y-3 sm:space-y-4">
                    <div class="flex items-center gap-3 bg-white/30 backdrop-blur-sm rounded-xl p-3 sm:p-4">
                        <div class="text-xl sm:text-2xl text-terre-marron">🐚</div>
                        <div>
                            <div class="text-terre-marron/70 text-xs sm:text-sm">Montant à ajouter</div>
                            <div class="text-terre-marron font-medium text-sm sm:text-base" id="addAmount">0 FCFA</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const currentBalance = {{ $wallet->balance }};
    
    function setAmount(amount) {
        document.getElementById('amount').value = amount;
        updateTotal();
    }
    
    function updateTotal() {
        const amount = parseInt(document.getElementById('amount').value) || 0;
        const newBalance = currentBalance + amount;
        
        document.getElementById('newBalance').textContent = newBalance.toLocaleString('fr-FR');
        document.getElementById('addAmount').textContent = amount.toLocaleString('fr-FR') + ' FCFA';
    }


</script>
@endsection