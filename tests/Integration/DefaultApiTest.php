<?php

 test('Request the home page', function () {
    $response = $this->httpClient->request('GET', '/');
    expect($response->getStatusCode())->toBe(200);
    expect($response->toArray())->toBe(['message' => 'home page']);
});

test('Request the about page', function () {
    $response = $this->httpClient->request('GET', '/about');
    expect($response->getStatusCode())->toBe(200);
    expect($response->toArray())->toBe(['message' => 'about page']);
});

test('Request a not found page', function () {
    $response = $this->httpClient->request('GET', '/fizz');
    expect($response->getStatusCode())->toBe(404);
});
