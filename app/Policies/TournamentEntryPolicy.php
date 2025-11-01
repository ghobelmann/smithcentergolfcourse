<?php

namespace App\Policies;

use App\Models\TournamentEntry;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TournamentEntryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TournamentEntry $tournamentEntry): bool
    {
        // Users can view their own entries, or admins can view all
        return $user->id === $tournamentEntry->user_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TournamentEntry $tournamentEntry): bool
    {
        // Users can update their own entries, or admins can update all
        return $user->id === $tournamentEntry->user_id || $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TournamentEntry $tournamentEntry): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TournamentEntry $tournamentEntry): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TournamentEntry $tournamentEntry): bool
    {
        return false;
    }
}
