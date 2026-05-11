<?php

use App\Models\User;
use App\Models\Series;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns Initiate rank for users with less than 20 series', function () {
    $user = User::factory()->create();

    // Create 19 series
    Series::factory()->count(19)->create(['user_id' => $user->id]);

    expect($user->librarian_rank)->toBe('Initiate');
});

it('returns Apprentice rank for users with 20 to 49 series', function () {
    $user = User::factory()->create();

    // Create 20 series
    Series::factory()->count(20)->create(['user_id' => $user->id]);

    expect($user->librarian_rank)->toBe('Apprentice');

    // Create 29 more series (total 49)
    Series::factory()->count(29)->create(['user_id' => $user->id]);

    // Refresh the user model or recalculate
    $user->refresh();

    expect($user->librarian_rank)->toBe('Apprentice');
});

it('returns Archivist rank for users with 50 to 99 series', function () {
    $user = User::factory()->create();

    // Create 50 series
    Series::factory()->count(50)->create(['user_id' => $user->id]);

    expect($user->librarian_rank)->toBe('Archivist');

    // Create 49 more series (total 99)
    Series::factory()->count(49)->create(['user_id' => $user->id]);

    $user->refresh();

    expect($user->librarian_rank)->toBe('Archivist');
});

it('returns Senior Archivist rank for users with 100 to 199 series', function () {
    $user = User::factory()->create();

    // Create 100 series
    Series::factory()->count(100)->create(['user_id' => $user->id]);

    expect($user->librarian_rank)->toBe('Senior Archivist');

    // Create 99 more series (total 199)
    Series::factory()->count(99)->create(['user_id' => $user->id]);

    $user->refresh();

    expect($user->librarian_rank)->toBe('Senior Archivist');
});

it('returns Grand Librarian rank for users with 200 or more series', function () {
    $user = User::factory()->create();

    // Create 200 series
    Series::factory()->count(200)->create(['user_id' => $user->id]);

    expect($user->librarian_rank)->toBe('Grand Librarian');

    // Create 50 more series (total 250)
    Series::factory()->count(50)->create(['user_id' => $user->id]);

    $user->refresh();

    expect($user->librarian_rank)->toBe('Grand Librarian');
});
