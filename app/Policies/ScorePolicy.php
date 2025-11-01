<?php

namespace App\Policies;

use App\Models\Score;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ScorePolicy
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
    public function view(User $user, Score $score): bool
    {
        // Admins can view all scores, users can view their own tournament entries
        return $user->isAdmin() || $user->id === $score->tournamentEntry->user_id;
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
    public function update(User $user, Score $score): bool
    {
        // Admins can update all scores, users can update their own tournament entries
        return $user->isAdmin() || $user->id === $score->tournamentEntry->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Score $score): bool
    {
        // Admins can delete all scores, users can delete their own tournament entries
        return $user->isAdmin() || $user->id === $score->tournamentEntry->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Score $score): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Score $score): bool
    {
        return false;
    }
}
