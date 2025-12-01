<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TontineRound extends Model
{
    protected $fillable = [
        'tontine_id',
        'beneficiary_id',
        'round_number',
        'start_date',
        'end_date',
        'expected_amount',
        'collected_amount',
        'status',
        'completed_at'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'completed_at' => 'datetime',
        'expected_amount' => 'decimal:2',
        'collected_amount' => 'decimal:2'
    ];

    public function tontine(): BelongsTo
    {
        return $this->belongsTo(Tontine::class);
    }

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(User::class, 'beneficiary_id');
    }

    public function isComplete(): bool
    {
        return $this->collected_amount >= $this->expected_amount;
    }

    public function getProgressPercentage(): float
    {
        if ($this->expected_amount == 0) return 0;
        return min(100, ($this->collected_amount / $this->expected_amount) * 100);
    }
}