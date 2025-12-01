<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    protected $fillable = [
        'tontine_id',
        'user_id',
        'amount',
        'round_number',
        'status',
        'payment_method',
        'transaction_reference',
        'due_date',
        'paid_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date',
        'paid_at' => 'datetime'
    ];

    public function tontine()
    {
        return $this->belongsTo(Tontine::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
