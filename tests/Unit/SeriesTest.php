<?php

use App\Models\Series;

test('formatted chapters returns correct format with both values', function () {
    $series = new Series([
        'chapters_completed' => 5,
        'chapters_total' => 10,
    ]);

    expect($series->formatted_chapters)->toBe('Ch. 5 / 10');
});

test('formatted chapters returns correct format with only completed chapters', function () {
    $series = new Series([
        'chapters_completed' => 5,
        'chapters_total' => null,
    ]);

    expect($series->formatted_chapters)->toBe('Ch. 5 / ?');
});

test('formatted chapters returns correct format with no values', function () {
    $series = new Series([
        'chapters_completed' => null,
        'chapters_total' => null,
    ]);

    expect($series->formatted_chapters)->toBe('Ch. 0 / ?');
});

test('formatted chapters returns correct format with zero total chapters', function () {
    $series = new Series([
        'chapters_completed' => 5,
        'chapters_total' => 0,
    ]);

    expect($series->formatted_chapters)->toBe('Ch. 5 / ?');
});

test('formatted chapters returns correct format with only total chapters', function () {
    $series = new Series([
        'chapters_completed' => null,
        'chapters_total' => 10,
    ]);

    expect($series->formatted_chapters)->toBe('Ch. 0 / 10');
});
