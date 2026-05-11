<?php

test('the application returns a successful response', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('root redirects to login', function () {
    $response = $this->get('/');

    $response->assertStatus(302);
    $response->assertRedirect('/login');
});
