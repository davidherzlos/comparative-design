<?php

use OpenChat\Router;
use OpenChat\UseCase\DefaultApi;
use OpenChat\App;

describe('App should', function () {

    test('ask the Router to add the expected request handler ', function () {
        $router = Mockery::mock(Router::class);
        $router->shouldReceive('add')->withArgs(
            fn($arg1, $arg2, $arg3) => $arg1 == 'POST' && $arg2 == 'foo' && is_callable($arg3)
        );
        $app = new App($router);
        $app->registerEndpoint('POST', '/foo', fn() => ['foo' => 'bar']);
        expect(true)->toBe(true); // Just to make Pest happy.
    });

    test('ask the Router for the expected request handler', function () {
        $router = Mockery::mock(Router::class);
        $router->shouldReceive('get')->with('GET', 'home');
        $app = new App($router);
        $app->dispatch('GET', '/home');
        expect(true)->toBe(true); // Just to make Pest happy.
    });

    test('dispatch a default response when handler is not found', function () {
        $router = Mockery::mock(Router::class);
        $router->shouldReceive('get')->with('GET', 'fizz')->andReturn(null);
        $app = new App($router);
        expect($app->dispatch('GET', '/fizz'))->toBe(['statusCode' => 404, 'data' => ['message' => 'page not found']]);
    });

    test('dispatch a valid response when the handler found is a closure', function () {
        $router = Mockery::mock(Router::class);
        $router->shouldReceive('get')->with('GET', 'fizz')->andReturn(fn() => ['statusCode' => 200, 'data' => ['foo' => 'bar']]);
        $app = new App($router);
        expect($app->dispatch('GET', '/fizz'))->toBe(['statusCode' => 200, 'data' => ['foo' => 'bar']]);
    });

    test('dispatch a valid response when the handler found is a method', function () {
        $router = Mockery::mock(Router::class);
        $router->shouldReceive('get')->with('GET', 'fizz')->andReturn('DefaultApi::about');
        $app = new App($router);
        expect($app->dispatch('GET', '/fizz'))->toBe(['statusCode' => 200, 'data' => ['message' => 'about page']]);
    });

    test('dispatch a default response when handler is not valid', function () {
        $router = Mockery::mock(Router::class);
        $router->shouldReceive('get')->with('GET', 'fizz')->andReturn('MissingClass::method');
        $app = new App($router);
        expect($app->dispatch('GET', '/fizz'))->toBe(['statusCode' => 404, 'data' => ['message' => 'page not found']]);
    });

});
// Suena atractivo inspeccionar los objetos en los tests mediante mocks.
// Pero no veo como es que es util mockear como llame el metodo y que resultado obtuve.
// Eso es algo bueno de ver en los videos y el libro.
// Estoy entrando en el mock hell, creo.
