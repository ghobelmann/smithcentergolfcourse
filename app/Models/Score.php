<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Score extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_entry_id',
        'team_id',
        'hole_number',
        'strokes',
        'par',
        'notes',
    ];

    public function tournamentEntry(): BelongsTo
    {
        return $this->belongsTo(TournamentEntry::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    // Helper methods
    public function getScoreDescription(): string
    {
        $diff = $this->strokes - $this->par;
        
        return match($diff) {
            -3 => 'Albatross',
            -2 => 'Eagle',
            -1 => 'Birdie',
            0 => 'Par',
            1 => 'Bogey',
            2 => 'Double Bogey',
            default => $diff > 0 ? '+' . $diff : (string) $diff
        };
    }

    public function isUnderPar(): bool
    {
        return $this->strokes < $this->par;
    }

    public function isOverPar(): bool
    {
        return $this->strokes > $this->par;
    }
}