<?php

use OpenChat\Router;

it('picks the correct handler by the given key', function () {
    $router = new Router();
    expect($router->getHandler('home'))->toBeCallable();
});

it('returns an empty handler when the key is not found', function () {
    $router = new Router();
    expect($router->getHandler('fizz'))->toBeCallable();
});
