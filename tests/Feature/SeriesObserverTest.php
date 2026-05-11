<?php

use App\Models\ActivityLog;
use App\Models\Series;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('it logs activity when a series is deleted by an authenticated user', function () {
    $user = User::factory()->create();
    // Use withoutEvents to bypass the 'created' observer which creates an ActivityLog
    $series = Series::withoutEvents(function () use ($user) {
        return Series::factory()->create(['user_id' => $user->id]);
    });

    $this->actingAs($user);

    $series->delete();

    $this->assertDatabaseHas('activity_logs', [
        'user_id' => $user->id,
        'series_id' => null,
        'action' => ActivityLog::ACTION_DELETED,
        'description' => "Removed \"{$series->title}\" from the Imperial Archives.",
    ]);

    $log = ActivityLog::where('action', ActivityLog::ACTION_DELETED)
        ->whereJsonContains('metadata->title', $series->title)
        ->first();
    expect($log)->not->toBeNull();
    expect($log->metadata)->toBe(['title' => $series->title]);
});

test('it logs activity when a series is deleted without an authenticated user', function () {
    $user = User::factory()->create();
    $series = Series::withoutEvents(function () use ($user) {
        return Series::factory()->create(['user_id' => $user->id]);
    });

    // Ensure no user is authenticated
    $this->assertGuest();

    $series->delete();

    $this->assertDatabaseHas('activity_logs', [
        'user_id' => $user->id, // Should fallback to series->user_id
        'series_id' => null,
        'action' => ActivityLog::ACTION_DELETED,
        'description' => "Removed \"{$series->title}\" from the Imperial Archives.",
    ]);

    $log = ActivityLog::where('action', ActivityLog::ACTION_DELETED)
        ->whereJsonContains('metadata->title', $series->title)
        ->first();
    expect($log)->not->toBeNull();
    expect($log->metadata)->toBe(['title' => $series->title]);
});
