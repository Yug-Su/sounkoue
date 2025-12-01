<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Tontine extends Model
{
    protected $fillable = [
        'name',
        'description',
        'amount_per_contribution',
        'frequency',
        'max_members',
        'rotation_order',
        'status',
        'creator_id',
        'start_date',
        'end_date',
        'rotation_sequence',
        'current_round',
        'require_approval',
        'is_private',
        'invite_code',
        'turn_order',
        'next_turn_date',
        'last_contribution_date',
        'auto_advance_turns'
    ];

    protected $casts = [
        'rotation_sequence' => 'array',
        'turn_order' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'next_turn_date' => 'datetime',
        'last_contribution_date' => 'datetime',
        'amount_per_contribution' => 'decimal:2',
        'auto_advance_turns' => 'boolean'
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(TontineMember::class);
    }

    public function contributions(): HasMany
    {
        return $this->hasMany(Contribution::class);
    }

    public function distributions(): HasMany
    {
        return $this->hasMany(Distribution::class);
    }

    public function activeMembers(): HasMany
    {
        return $this->members()->where('status', 'active');
    }

    public function rounds(): HasMany
    {
        return $this->hasMany(TontineRound::class);
    }

    public function currentRound(): ?TontineRound
    {
        return $this->rounds()->where('status', 'active')->first();
    }

    public function initializeTurnOrder(): void
    {
        $members = $this->activeMembers()->get();
        
        switch ($this->rotation_order) {
            case 'alphabetical':
                $order = $members->sortBy('name')->pluck('user_id')->toArray();
                break;
            case 'random':
                $order = $members->pluck('user_id')->shuffle()->toArray();
                break;
            default:
                $order = $members->pluck('user_id')->toArray();
        }
        
        $this->update(['turn_order' => $order]);
        $this->createRounds();
    }

    public function createRounds(): void
    {
        if (!$this->turn_order) return;
        
        $startDate = $this->start_date ?? now();
        
        foreach ($this->turn_order as $index => $userId) {
            $roundStartDate = $this->calculateRoundDate($startDate, $index);
            $roundEndDate = $this->calculateRoundDate($startDate, $index + 1);
            
            TontineRound::create([
                'tontine_id' => $this->id,
                'beneficiary_id' => $userId,
                'round_number' => $index + 1,
                'start_date' => $roundStartDate,
                'end_date' => $roundEndDate,
                'expected_amount' => $this->amount_per_contribution * count($this->turn_order),
                'status' => $index === 0 ? 'active' : 'pending'
            ]);
        }
        
        $this->update(['next_turn_date' => $this->calculateRoundDate($startDate, 1)]);
    }

    private function calculateRoundDate($startDate, $roundIndex): \Carbon\Carbon
    {
        $date = \Carbon\Carbon::parse($startDate);
        
        switch ($this->frequency) {
            case 'daily':
                return $date->addDays($roundIndex);
            case 'weekly':
                return $date->addWeeks($roundIndex);
            case 'biweekly':
                return $date->addWeeks($roundIndex * 2);
            case 'monthly':
                return $date->addMonths($roundIndex);
            case 'quarterly':
                return $date->addMonths($roundIndex * 3);
            default:
                return $date->addMonths($roundIndex);
        }
    }

    public function advanceToNextRound(): bool
    {
        $currentRound = $this->currentRound();
        if (!$currentRound || !$currentRound->isComplete()) {
            return false;
        }
        
        $currentRound->update([
            'status' => 'completed',
            'completed_at' => now()
        ]);
        
        $nextRound = $this->rounds()
            ->where('round_number', $currentRound->round_number + 1)
            ->first();
            
        if ($nextRound) {
            $nextRound->update(['status' => 'active']);
            $this->update([
                'current_round' => $nextRound->round_number,
                'last_contribution_date' => now()
            ]);
            return true;
        }
        
        // Tontine terminée
        $this->update(['status' => 'completed']);
        return false;
    }
}
