<?php

test('Register a new user', function () {
    // given
    $payload = [
        'username' => 'davidoc',
        'password' => 'david061685',
        'about' => 'About David'
    ];

    // when
    $response = $this->httpClient->request('POST', '/users', ['json' => $payload]);

    // then
    expect($response->getStatusCode())->toBe(201);
    expect($response->toArray())->toMatchArray($payload);
    expect($response->toArray()['id'])->toBeGreaterThanOrEqual(1);
})->todo();
