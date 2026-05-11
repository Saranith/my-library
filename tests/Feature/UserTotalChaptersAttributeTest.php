<?php

use App\Models\Series;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('getTotalChaptersAttribute calculates the sum of chapters_completed from all series correctly', function () {
    $user = User::factory()->create();

    Series::factory()->create([
        'user_id' => $user->id,
        'chapters_completed' => 10,
    ]);

    Series::factory()->create([
        'user_id' => $user->id,
        'chapters_completed' => 25,
    ]);

    Series::factory()->create([
        'user_id' => $user->id,
        'chapters_completed' => 0,
    ]);

    expect($user->total_chapters)->toBe(35);
});

test('getTotalChaptersAttribute returns 0 when the user has no series', function () {
    $user = User::factory()->create();

    expect($user->total_chapters)->toBe(0);
});
