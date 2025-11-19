<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class League extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'season_start',
        'season_end',
        'day_of_week',
        'tee_time',
        'holes',
        'entry_fee_per_week',
        'season_fee',
        'max_members',
        'weeks_count_for_championship',
        'status',
        'points_system',
        'points_structure',
        'participation_points',
        'participation_points_value',
        'number_of_flights',
        'flight_prizes',
    ];

    protected $casts = [
        'season_start' => 'date',
        'season_end' => 'date',
        'tee_time' => 'datetime:H:i',
        'entry_fee_per_week' => 'decimal:2',
        'season_fee' => 'decimal:2',
        'points_structure' => 'array',
        'participation_points' => 'boolean',
        'flight_prizes' => 'boolean',
    ];

    /**
     * Get the tournaments associated with this league
     */
    public function tournaments(): HasMany
    {
        return $this->hasMany(Tournament::class)->orderBy('start_date');
    }

    /**
     * Get the league members
     */
    public function members(): HasMany
    {
        return $this->hasMany(LeagueMember::class);
    }

    /**
     * Get active league members
     */
    public function activeMembers(): HasMany
    {
        return $this->members()->where('is_active', true);
    }

    /**
     * Get users enrolled in this league
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'league_members')
            ->withPivot(['handicap', 'season_fee_paid', 'is_active', 'joined_date', 'weeks_played'])
            ->withTimestamps();
    }

    /**
     * Get all standings for this league
     */
    public function standings(): HasMany
    {
        return $this->hasMany(LeagueStanding::class);
    }

    /**
     * Get season standings (cumulative points)
     */
    public function seasonStandings()
    {
        return $this->standings()
            ->selectRaw('user_id, league_id, MAX(total_points) as total_points, MAX(weeks_played) as weeks_played, AVG(average_score) as avg_score')
            ->groupBy('user_id', 'league_id')
            ->orderByDesc('total_points')
            ->with('user');
    }

    /**
     * Check if league is accepting new members
     */
    public function hasSpaceAvailable(): bool
    {
        if ($this->max_members === null) {
            return true;
        }
        return $this->activeMembers()->count() < $this->max_members;
    }

    /**
     * Check if user is a member
     */
    public function hasMember(User $user): bool
    {
        return $this->members()->where('user_id', $user->id)->where('is_active', true)->exists();
    }

    /**
     * Get total number of weeks in season
     */
    public function getTotalWeeks(): int
    {
        return $this->tournaments()->count();
    }

    /**
     * Get current week number
     */
    public function getCurrentWeek(): ?int
    {
        $currentTournament = $this->tournaments()
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();
        
        return $currentTournament?->week_number;
    }

    /**
     * Check league status
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Get type label
     */
    public function getTypeLabel(): string
    {
        return match($this->type) {
            'mens' => "Men's League",
            'womens' => "Women's League",
            'mixed' => 'Mixed League',
            default => 'League',
        };
    }

    /**
     * Calculate points based on placement and league settings
     */
    public function calculatePoints(int $position, int $totalParticipants, bool $participated = true): int
    {
        if (!$participated) {
            return 0;
        }

        $points = 0;

        // Add participation points
        if ($this->participation_points) {
            $points += $this->participation_points_value;
        }

        // Add placement points based on system
        if ($this->points_system === 'placement') {
            $points += $this->calculatePlacementPoints($position);
        } elseif ($this->points_system === 'custom' && $this->points_structure) {
            $points += $this->points_structure[$position] ?? 0;
        }

        return $points;
    }

    /**
     * Calculate placement points (higher placement = more points)
     */
    private function calculatePlacementPoints(int $position): int
    {
        // Default: 1st = 10pts, 2nd = 9pts, 3rd = 8pts, etc.
        return max(0, 11 - $position);
    }

    /**
     * Get week by number
     */
    public function getWeek(int $weekNumber): ?Tournament
    {
        return $this->tournaments()->where('week_number', $weekNumber)->first();
    }
}
