<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeagueMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'league_id',
        'user_id',
        'handicap',
        'season_fee_paid',
        'is_active',
        'joined_date',
        'last_played',
        'weeks_played',
        'notes',
    ];

    protected $casts = [
        'handicap' => 'decimal:2',
        'season_fee_paid' => 'decimal:2',
        'is_active' => 'boolean',
        'joined_date' => 'date',
        'last_played' => 'date',
    ];

    /**
     * Get the league this membership belongs to
     */
    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }

    /**
     * Get the user (member)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if season fee is fully paid
     */
    public function hasCompletedPayment(): bool
    {
        return $this->season_fee_paid >= $this->league->season_fee;
    }

    /**
     * Get outstanding balance
     */
    public function getOutstandingBalance(): float
    {
        return max(0, $this->league->season_fee - $this->season_fee_paid);
    }

    /**
     * Mark as active/inactive
     */
    public function activate(): void
    {
        $this->update(['is_active' => true]);
    }

    public function deactivate(): void
    {
        $this->update(['is_active' => false]);
    }
}
