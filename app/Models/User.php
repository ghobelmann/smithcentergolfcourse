<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
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
        'password',
        'phone',
        'handicap',
        'home_course',
        'is_admin',
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
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    public function tournamentEntries(): HasMany
    {
        return $this->hasMany(TournamentEntry::class);
    }

    public function tournaments(): BelongsToMany
    {
        return $this->belongsToMany(Tournament::class, 'tournament_entries')
                    ->withPivot(['handicap', 'entry_fee_paid', 'checked_in', 'registered_at'])
                    ->withTimestamps();
    }

    public function captainedTeams(): HasMany
    {
        return $this->hasMany(Team::class, 'captain_id');
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_members')
                    ->withPivot(['handicap'])
                    ->withTimestamps();
    }

    // User scores are accessed through tournament entries
    // Use: $user->tournamentEntries()->with('scores') to get scores

    // Helper methods
    public function hasHandicap(): bool
    {
        return $this->handicap !== null;
    }

    public function getDisplayHandicap(): string
    {
        return $this->handicap ? (string) $this->handicap : 'N/A';
    }

    public function isAdmin(): bool
    {
        return $this->is_admin === true;
    }

    public function canManageTournaments(): bool
    {
        return $this->isAdmin();
    }
}
