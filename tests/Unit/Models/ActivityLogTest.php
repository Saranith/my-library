<?php

use App\Models\ActivityLog;

test('returns error color for deleted action', function () {
    $activityLog = new ActivityLog(['action' => ActivityLog::ACTION_DELETED]);

    expect($activityLog->action_color)->toBe('text-error border-error');
});

test('returns primary color for added action', function () {
    $activityLog = new ActivityLog(['action' => ActivityLog::ACTION_ADDED]);

    expect($activityLog->action_color)->toBe('text-primary border-primary');
});

test('returns primary color for edited action', function () {
    $activityLog = new ActivityLog(['action' => ActivityLog::ACTION_EDITED]);

    expect($activityLog->action_color)->toBe('text-primary border-primary');
});

test('returns primary color for unknown action', function () {
    $activityLog = new ActivityLog(['action' => 'some_unknown_action']);

    expect($activityLog->action_color)->toBe('text-primary border-primary');
});
