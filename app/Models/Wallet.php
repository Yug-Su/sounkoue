<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    protected $fillable = [
        'user_id',
        'balance',
        'currency',
        'is_active'
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'user_id', 'user_id');
    }

    public function addFunds(float $amount, string $description = null): Transaction
    {
        $this->increment('balance', $amount);
        
        return Transaction::create([
            'user_id' => $this->user_id,
            'type' => 'deposit',
            'amount' => $amount,
            'currency' => $this->currency,
            'status' => 'completed',
            'description' => $description ?? 'Dépôt de fonds',
            'processed_at' => now()
        ]);
    }

    public function deductFunds(float $amount, string $description = null): Transaction
    {
        if ($this->balance < $amount) {
            throw new \Exception('Solde insuffisant');
        }

        $this->decrement('balance', $amount);
        
        return Transaction::create([
            'user_id' => $this->user_id,
            'type' => 'withdrawal',
            'amount' => $amount,
            'currency' => $this->currency,
            'status' => 'completed',
            'description' => $description ?? 'Retrait de fonds',
            'processed_at' => now()
        ]);
    }
}