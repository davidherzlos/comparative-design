<?php

use Symfony\Component\HttpClient\HttpClient;

/**
 * Setup and teardown for each test.
 */

beforeEach(function () {
    $client = HttpClient::create();
    $this->httpClient = $client->withOptions(['base_uri' => 'http://localhost:8080']);
});

afterEach(function () {
    $this->httpClient = null;
});

/**
 * Test escenarios start here.
 */

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
    $response = $this->httpClient->request('GET', '/buzz');
    expect($response->getStatusCode())->toBe(404);
});

