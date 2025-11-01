<?php

namespace App\Policies;

use App\Models\Tournament;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TournamentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Anyone can view tournaments list
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Tournament $tournament): bool
    {
        return true; // Anyone can view individual tournaments
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin(); // Only admins can create tournaments
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Tournament $tournament): bool
    {
        return $user->isAdmin(); // Only admins can update tournaments
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Tournament $tournament): bool
    {
        return $user->isAdmin(); // Only admins can delete tournaments
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Tournament $tournament): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Tournament $tournament): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can assign cards for the tournament.
     */
    public function assignCards(User $user, Tournament $tournament): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can print all scorecards for the tournament.
     */
    public function printScorecards(User $user, Tournament $tournament): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can setup tournament cards.
     */
    public function setupCards(User $user, Tournament $tournament): bool
    {
        return $user->isAdmin();
    }
}
