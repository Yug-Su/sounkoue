<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'tontine_id',
        'type',
        'amount',
        'currency',
        'status',
        'payment_method',
        'external_reference',
        'phone_number',
        'description',
        'metadata',
        'processed_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'array',
        'processed_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tontine(): BelongsTo
    {
        return $this->belongsTo(Tontine::class);
    }

    public function scopeContributions($query)
    {
        return $query->where('type', 'contribution');
    }

    public function scopeDistributions($query)
    {
        return $query->where('type', 'distribution');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}