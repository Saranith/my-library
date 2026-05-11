<?php

namespace App\Providers;

use App\Models\Series;
use App\Observers\SeriesObserver;
use App\Policies\SeriesPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Series::observe(SeriesObserver::class);

        Gate::policy(Series::class, SeriesPolicy::class);
    }
}
