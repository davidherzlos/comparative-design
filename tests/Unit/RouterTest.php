<?php

use OpenChat\Router;

describe('Router should', function () {

    test('add new routes', function () {
        $router = new Router();
        $router->add('POST', 'hello', fn() => false);
        expect($router->count())->toBe(1);
    });

    test('pick handlers always as callables', function () {
        $router = new Router();
        $router->add('GET', 'about', fn() => false);
        expect($router->get('GET', 'about'))->toBeCallable();
    });

    test('pick the expected handler', function () {
        $router = new Router();
        $router->add('GET', 'about', fn() => true);
        expect($router->get('GET', 'about')())->toBe(true);
    });

    test('return null when the handler is not found', function () {
        $router = new Router();
        expect($router->get('POST', 'fizz'))->toBe(null);
    });
});


