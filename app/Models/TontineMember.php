<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TontineMember extends Model
{
    protected $fillable = [
        'tontine_id',
        'user_id',
        'status',
        'position_in_rotation',
        'has_received_distribution',
        'joined_at'
    ];

    protected $casts = [
        'joined_at' => 'date',
        'has_received_distribution' => 'boolean'
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
