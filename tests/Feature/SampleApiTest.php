<?php

 test('Request home endpont', function () {
    $response = $this->http->request('GET', '/');
    expect($response->getStatusCode())->toBe(200);
    expect($response->toArray())->toBe(['page' => 'home']);
});

test('Request an invalid endpoint', function () {
    $response = $this->http->request('GET', '/invalid');
    expect($response->getStatusCode())->toBe(404);
});
