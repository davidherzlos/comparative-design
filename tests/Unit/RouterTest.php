<?php

use OpenChat\Router;

describe('Router should', function () {

    test('add new routes', function () {
        $router = new Router();
        $router->add('POST', 'hello', fn() => true);
        expect($router->count())->toBe(1);
    });

    test('pick the expected handler', function () {
        $router = new Router();
        $router->add('GET', 'about', fn() => 'about page');
        expect($router->get('GET', 'about'))->toBeCallable();
        expect($router->get('GET', 'about')())->toBe('about page');
    });

    test('return null when the handler is not found', function () {
        $router = new Router();
        expect($router->get('POST', 'fizz'))->toBe(null);
    });
});


