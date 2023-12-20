<?php

use OpenChat\Router;
use OpenChat\App;

describe('App should', function () {

    test('ask the Router to add the expected request handler ', function () {
        $router = Mockery::mock(Router::class);
        $router->shouldReceive('add')->withArgs(
            fn($arg1, $arg2, $arg3) => $arg1 == 'POST' && $arg2 == 'foo' && is_callable($arg3)
        );
        $app = new App($router);
        $app->registerEndpoint('POST', '/foo', fn() => true);
        expect(true)->toBe(true); // Just to make Pest happy.
    });

    test('ask the Router for the expected request handler', function () {
        $router = Mockery::mock(Router::class);
        $router->shouldReceive('get')->with('GET', 'home');
        $app = new App($router);
        $app->dispatch('GET', '/home');
        expect(true)->toBe(true); // Just to make Pest happy.
    });

    test('dispatch a default response when no handler is not found', function () {
        $router = Mockery::mock(Router::class);
        $router->shouldReceive('get')->with('GET', 'fizz')->andReturn(null);
        $app = new App($router);
        expect($app->dispatch('GET', '/fizz'))->toMatchArray(['ok' => false, 'message' => 'page not found']);
    });

    test('dispatch a valid response when a handler is found', function () {
        $router = Mockery::mock(Router::class);
        $router->shouldReceive('get')->with('GET', 'fizz')->andReturn(fn() => ['success' => true]);
        $app = new App($router);
        expect($app->dispatch('GET', '/fizz'))->toBe(['success' => true]);
    });

});
// Suena atractivo inspeccionar los objetos en los tests mediante mocks.
// Pero no veo como es que es util mockear como llame el metodo y que resultado obtuve.
// Eso es algo bueno de ver en los videos y el libro.
// Estoy entrando en el mock hell, creo.
