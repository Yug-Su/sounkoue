<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    protected $fillable = [
        'tontine_id',
        'recipient_id',
        'amount',
        'round_number',
        'status',
        'payment_method',
        'transaction_reference',
        'distributed_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'distributed_at' => 'datetime'
    ];

    public function tontine()
    {
        return $this->belongsTo(Tontine::class);
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
}
