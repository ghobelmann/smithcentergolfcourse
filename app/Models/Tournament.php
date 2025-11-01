<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'holes',
        'format',
        'team_size',
        'entry_fee',
        'max_participants',
        'status',
        'course_id',
        'course_tee_id',
        'number_of_flights',
        'tie_breaking_method',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'entry_fee' => 'decimal:2',
    ];

    public function entries(): HasMany
    {
        return $this->hasMany(TournamentEntry::class);
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'tournament_entries')
                    ->withPivot(['handicap', 'entry_fee_paid', 'checked_in', 'registered_at'])
                    ->withTimestamps();
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function courseTee(): BelongsTo
    {
        return $this->belongsTo(CourseTee::class);
    }

    // Helper methods
    public function isUpcoming(): bool
    {
        return $this->status === 'upcoming';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function getParticipantCount(): int
    {
        if ($this->isScramble()) {
            return $this->teams()->count();
        }
        return $this->entries()->count();
    }

    public function hasSpaceAvailable(): bool
    {
        if ($this->max_participants === null) {
            return true;
        }
        
        return $this->getParticipantCount() < $this->max_participants;
    }

    // Helper methods for tournament format
    public function isScramble(): bool
    {
        return $this->format === 'scramble';
    }

    public function isIndividual(): bool
    {
        return $this->format === 'individual';
    }

    public function getFormatDescription(): string
    {
        if ($this->isScramble()) {
            return "{$this->team_size} Player Scramble";
        }
        return 'Individual Play';
    }

    public function getMaxTeamSize(): int
    {
        return $this->team_size ?? 1;
    }
}