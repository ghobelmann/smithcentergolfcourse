<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TournamentEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id',
        'user_id',
        'handicap',
        'entry_fee_paid',
        'checked_in',
        'registered_at',
        'starting_hole',
        'group_letter',
        'card_order',
    ];

    protected $casts = [
        'entry_fee_paid' => 'decimal:2',
        'checked_in' => 'boolean',
        'registered_at' => 'datetime',
    ];

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scores(): HasMany
    {
        return $this->hasMany(Score::class);
    }

    // Helper methods
    public function getTotalScore(): int
    {
        return $this->scores()->sum('strokes');
    }

    public function getScoreRelativeToPar(): int
    {
        $totalStrokes = $this->getTotalScore();
        $totalPar = $this->scores()->sum('par');
        
        return $totalStrokes - $totalPar;
    }

    public function getCompletedHoles(): int
    {
        return $this->scores()->count();
    }

    public function isRoundComplete(): bool
    {
        return $this->getCompletedHoles() >= $this->tournament->holes;
    }
}