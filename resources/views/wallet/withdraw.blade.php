@extends('layouts.app')

@section('title', 'Retirer du wallet - Soun Kouê')
@section('page-title', 'Retirer de votre wallet')
@section('page-description', 'Transférez des fonds de votre wallet vers votre mobile money')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 sm:py-8">
    <div class="grid md:grid-cols-2 gap-4 sm:gap-8">
        <!-- Left - Withdraw Form -->
        <div class="bg-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 md:p-8">
            <form method="POST" action="{{ route('wallet.withdraw.process') }}" class="space-y-6">
                @csrf
                
                <!-- Wallet Info -->
                <div class="bg-ivoire rounded-2xl p-6">
                    <div class="flex justify-between mb-3">
                        <span class="text-terre-marron/70">Solde actuel</span>
                        <span class="text-terre-marron">{{ number_format($wallet->balance, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-terre-marron/70">Montant à retirer</span>
                        <div class="flex items-center gap-2">
                            <span class="text-xl sm:text-2xl text-cauri-gold">🐚</span>
                            <input type="number" name="amount" id="amount" min="100" step="100" required 
                                   class="text-lg sm:text-2xl font-bold text-terre-marron bg-white border-2 border-cauri-gold/30 focus:border-cauri-gold rounded-lg px-2 py-1 outline-none text-right w-28 sm:w-36"
                                   placeholder="0" oninput="updateTotal()">
                            <span class="text-base sm:text-xl text-terre-marron">FCFA</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="space-y-4">
                    <label class="text-terre-marron font-medium">Destination</label>
                    <div class="space-y-3">
                        <label class="flex items-center space-x-3 border-2 border-terre-marron rounded-xl p-4">
                            <input type="radio" name="payment_method" value="mobile_money" checked class="text-cauri-gold">
                            <div class="bg-gradient-to-br from-terre-marron to-terre-marron-dark rounded-lg p-2">
                                <i data-lucide="smartphone" class="w-5 h-5 text-cauri-gold"></i>
                            </div>
                            <div class="flex-1">
                                <div class="text-terre-marron font-medium">Mobile Money</div>
                                <div class="text-sm text-terre-marron/60">Vers votre numéro d'inscription</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Mobile Money Number (readonly) -->
                <div class="space-y-2">
                    <label for="phone_number" class="text-terre-marron font-medium">Numéro de destination</label>
                    <input
                        id="phone_number"
                        name="phone_number"
                        type="tel"
                        readonly
                        value="{{ $user->phone }}"
                        class="w-full border border-cauri-gold/30 bg-gray-50 rounded-xl px-3 py-3 outline-none text-gray-600"
                    />
                    <p class="text-xs text-terre-marron/60">Numéro enregistré lors de votre inscription</p>
                </div>

                <!-- Amount Presets -->
                <div class="space-y-2">
                    <label class="text-terre-marron font-medium">Montants rapides</label>
                    <div class="grid grid-cols-3 gap-2">
                        <button type="button" onclick="setAmount(5000)" class="bg-cauri-gold/10 text-terre-marron px-4 py-2 rounded-lg hover:bg-cauri-gold/20 transition-colors text-sm">
                            5,000
                        </button>
                        <button type="button" onclick="setAmount(10000)" class="bg-cauri-gold/10 text-terre-marron px-4 py-2 rounded-lg hover:bg-cauri-gold/20 transition-colors text-sm">
                            10,000
                        </button>
                        <button type="button" onclick="setAmount(25000)" class="bg-cauri-gold/10 text-terre-marron px-4 py-2 rounded-lg hover:bg-cauri-gold/20 transition-colors text-sm">
                            25,000
                        </button>
                    </div>
                </div>

                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-terre-marron to-terre-marron-dark hover:opacity-90 text-ivoire rounded-xl py-3 sm:py-4 md:py-6 font-bold transition-opacity text-sm sm:text-base"
                >
                    Initier le retrait
                </button>
            </form>
        </div>

        <!-- Right - Visual -->
        <div class="hidden md:block">
            <div class="bg-gradient-to-br from-cauri-gold to-cauri-gold-light rounded-2xl sm:rounded-3xl p-6 sm:p-8">
                <div class="mb-8">
                    <div class="text-terre-marron/70 mb-2">Nouveau solde</div>
                    <div class="text-3xl sm:text-4xl md:text-5xl font-bold text-terre-marron mb-4" id="newBalance">{{ number_format($wallet->balance, 0, ',', ' ') }}</div>
                    <div class="text-terre-marron/70">FCFA</div>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center gap-3 bg-white/30 backdrop-blur-sm rounded-xl p-4">
                        <div class="text-2xl text-terre-marron">🐚</div>
                        <div>
                            <div class="text-terre-marron/70 text-sm">Montant à retirer</div>
                            <div class="text-terre-marron font-medium" id="withdrawAmount">0 FCFA</div>
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
        if (amount > currentBalance) {
            alert('Montant supérieur au solde disponible');
            return;
        }
        document.getElementById('amount').value = amount;
        updateTotal();
    }
    
    function updateTotal() {
        const amount = parseInt(document.getElementById('amount').value) || 0;
        const newBalance = currentBalance - amount;
        
        if (amount > currentBalance) {
            document.getElementById('newBalance').textContent = 'Insuffisant';
            document.getElementById('newBalance').className = 'text-5xl font-bold text-red-500 mb-4';
        } else {
            document.getElementById('newBalance').textContent = newBalance.toLocaleString('fr-FR');
            document.getElementById('newBalance').className = 'text-5xl font-bold text-terre-marron mb-4';
        }
        
        document.getElementById('withdrawAmount').textContent = amount.toLocaleString('fr-FR') + ' FCFA';
    }
</script>
@endsection