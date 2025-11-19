<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeagueStanding extends Model
{
    use HasFactory;

    protected $fillable = [
        'league_id',
        'user_id',
        'tournament_id',
        'week_number',
        'position',
        'flight',
        'position_in_flight',
        'total_score',
        'score_vs_par',
        'points_earned',
        'participated',
        'total_points',
        'weeks_played',
        'best_score',
        'worst_score',
        'average_score',
    ];

    protected $casts = [
        'participated' => 'boolean',
        'average_score' => 'decimal:2',
    ];

    /**
     * Get the league
     */
    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }

    /**
     * Get the user (player)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the tournament (weekly event)
     */
    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    /**
     * Get formatted score vs par
     */
    public function getFormattedScoreVsPar(): string
    {
        if ($this->score_vs_par === null) {
            return '-';
        }

        if ($this->score_vs_par === 0) {
            return 'E';
        }

        return $this->score_vs_par > 0 
            ? '+' . $this->score_vs_par 
            : (string) $this->score_vs_par;
    }

    /**
     * Get position suffix (1st, 2nd, 3rd, etc.)
     */
    public function getPositionWithSuffix(): string
    {
        if ($this->position === null) {
            return '-';
        }

        $suffix = match($this->position % 10) {
            1 => $this->position === 11 ? 'th' : 'st',
            2 => $this->position === 12 ? 'th' : 'nd',
            3 => $this->position === 13 ? 'th' : 'rd',
            default => 'th',
        };

        return $this->position . $suffix;
    }

    /**
     * Scope for getting season totals for a user
     */
    public function scopeForUserSeason($query, int $leagueId, int $userId)
    {
        return $query->where('league_id', $leagueId)
                    ->where('user_id', $userId)
                    ->orderByDesc('week_number');
    }

    /**
     * Scope for getting week standings
     */
    public function scopeForWeek($query, int $leagueId, int $weekNumber)
    {
        return $query->where('league_id', $leagueId)
                    ->where('week_number', $weekNumber)
                    ->orderBy('position');
    }
}
