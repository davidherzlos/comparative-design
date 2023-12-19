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

test('it returns the expected response payload for the default endpoint', function () {
    $response = $this->httpClient->request('GET', '/home');
    expect($response->getStatusCode())->toBe(200);
    expect($response->toArray())->toBe(['ok' => true, 'message' => 'im the home page']);
});

test('it fetches the list of users in the system', function () {
    $response = $this->httpClient->request('GET', '/users');
    expect($response->getStatusCode())->toBe(200);
    expect($response->toArray())->toBe(['ok' => true, 'users' => []]);
});
