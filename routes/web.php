<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TontineController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SupportController;

// Routes publiques
Route::get('/', function () {
    return view('welcome');
})->middleware('redirect.if.authenticated');

// Route de jointure par code (accessible sans authentification)
Route::get('/join/{code}', [TontineController::class, 'joinByCode'])->name('tontines.join-by-code');

// Routes d'authentification
Route::middleware(['guest', 'redirect.if.authenticated'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Routes protégées
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Tontines
    Route::resource('tontines', TontineController::class);
    Route::post('/tontines/{tontine}/join', [TontineController::class, 'join'])->name('tontines.join');
    Route::delete('/tontines/{tontine}/leave', [TontineController::class, 'leave'])->name('tontines.leave');
    Route::post('/tontines/{tontine}/start', [TontineController::class, 'start'])->name('tontines.start');
    
    // Payments
    Route::get('/tontines/{tontine}/payment', [App\Http\Controllers\PaymentController::class, 'showPaymentForm'])->name('payments.form');
    Route::post('/tontines/{tontine}/payment', [App\Http\Controllers\PaymentController::class, 'processPayment'])->name('payments.process');
    
    // Contributions
    Route::get('/contributions', [App\Http\Controllers\ContributionController::class, 'index'])->name('contributions.index');
    
    // Wallet
    Route::get('/wallet', [App\Http\Controllers\WalletController::class, 'index'])->name('wallet.index');
    Route::get('/wallet/recharge', [App\Http\Controllers\WalletController::class, 'showRecharge'])->name('wallet.recharge');
    Route::post('/wallet/recharge', [App\Http\Controllers\WalletController::class, 'processRecharge'])->name('wallet.recharge.process');
    Route::get('/wallet/withdraw', [App\Http\Controllers\WalletController::class, 'showWithdraw'])->name('wallet.withdraw');
    Route::post('/wallet/withdraw', [App\Http\Controllers\WalletController::class, 'processWithdraw'])->name('wallet.withdraw.process');
    
    // Profile
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    
    // Support
    Route::get('/support', [SupportController::class, 'index'])->name('support.index');
});