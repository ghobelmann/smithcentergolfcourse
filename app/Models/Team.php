<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'captain_id',
        'tournament_id',
        'description',
        'entry_fee_paid',
        'checked_in',
        'registered_at',
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

    public function captain(): BelongsTo
    {
        return $this->belongsTo(User::class, 'captain_id');
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'team_members')
                    ->withPivot(['handicap'])
                    ->withTimestamps();
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

    public function getMemberCount(): int
    {
        return $this->members()->count();
    }

    public function canAddMembers(): bool
    {
        return $this->getMemberCount() < $this->tournament->team_size;
    }

    public function getAverageHandicap(): float
    {
        $handicaps = $this->members()->wherePivot('handicap', '!=', null)->pluck('team_members.handicap');
        return $handicaps->count() > 0 ? $handicaps->avg() : 0;
    }

    public function isCaptain(User $user): bool
    {
        return $this->captain_id === $user->id;
    }

    public function hasMember(User $user): bool
    {
        return $this->members()->where('users.id', $user->id)->exists();
    }
}
