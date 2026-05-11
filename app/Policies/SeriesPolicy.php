<?php

namespace App\Policies;

use App\Models\Series;
use App\Models\User;

class SeriesPolicy
{
    public function view(User $user, Series $series): bool
    {
        return $user->id === $series->user_id;
    }

    public function update(User $user, Series $series): bool
    {
        return $user->id === $series->user_id;
    }

    public function delete(User $user, Series $series): bool
    {
        return $user->id === $series->user_id;
    }
}
