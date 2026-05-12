<?php

namespace App\Policies;

use App\Models\Series;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SeriesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Any logged-in user can view the index page (which we filtered to their own series anyway)
        return true; 
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Series $series): bool
    {
        // A user can only view a series if they own it
        return $user->id === $series->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Any logged-in user can open the create form
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Series $series): bool
    {
        // A user can only edit a series if they own it
        return $user->id === $series->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Series $series): bool
    {
        // A user can only delete a series if they own it
        return $user->id === $series->user_id;
    }

    // You can usually leave restore() and forceDelete() as they are, 
    // or mirror the delete() logic if you are using soft deletes.
}
