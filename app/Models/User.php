<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'avatar',
        'status',
        'wallet_balance'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'password' => 'hashed',
            'wallet_balance' => 'decimal:2'
        ];
    }

    public function createdTontines()
    {
        return $this->hasMany(Tontine::class, 'creator_id');
    }

    public function tontineMembers()
    {
        return $this->hasMany(TontineMember::class);
    }

    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }

    public function distributions()
    {
        return $this->hasMany(Distribution::class, 'recipient_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getOrCreateWallet()
    {
        return $this->wallet ?: $this->wallet()->create([
            'balance' => 0,
            'currency' => 'XOF'
        ]);
    }
}
