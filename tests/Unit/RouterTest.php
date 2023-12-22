<?php

use OpenChat\Router;

describe('Router should', function () {

    test('add new routes', function () {
        $router = new Router();
        $router->add('POST', 'hello', fn() => true);
        expect($router->count())->toBe(1);
    });

    test('pick existing handlers as callables', function () {
        $router = new Router();
        $router->add('GET', 'about', fn() => true);
        expect($router->get('GET', 'about'))->toBeCallable();
    });

    test('return null when a handler was not found', function () {
        $router = new Router();
        expect($router->get('POST', 'fizz'))->toBe(null);
    });
});


