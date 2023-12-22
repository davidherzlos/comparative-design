<?php

use OpenChat\Router;
use OpenChat\Request;
use OpenChat\App;
use OpenChat\UseCase\DefaultApi;
use OpenChat\UseCase\UsersApi;

describe('App should', function () {

    test('message correctly the Router to add a new endpoint handler', function () {
        $router = Mockery::mock(Router::class);
        $router->shouldReceive('add')->withArgs(
            fn($arg1, $arg2, $arg3) => $arg1 == 'POST' && $arg2 == 'foo' && is_callable($arg3)
        );
        $app = new App($router, new Request());
        $app->registerEndpointHandler('POST', '/foo', fn() => ['foo' => 'bar']);
        expect(true)->toBe(true); // Just to make Pest happy.
    });

    test('message correctly the Router to get a handler', function () {
        $router = Mockery::mock(Router::class);
        $router->shouldReceive('get')->with('GET', 'home');
        $app = new App($router, new Request());
        $app->getEndpointHandler('GET', '/home');
        expect(true)->toBe(true); // Just to make Pest happy.
    });

    test('get a closure when the Router returnes nothing as endpoint handler', function () {
        $router = Mockery::mock(Router::class);
        $router->shouldReceive('get')->andReturn(null);
        $app = new App($router, new Request());
        expect($app->getEndpointHandler('GET', '/fizz'))->toBeCallable();
    });

    test('get the same closure the Router returned as endpoint handler', function () {
        $router = Mockery::mock(Router::class);
        $router->shouldReceive('get')->andReturn(fn() => true);
        $app = new App($router, new Request());
        expect($app->getEndpointHandler('GET', '/fizz'))->toBeCallable();
    });

    test('get a method when the Router returns a valid signature as endpoint handler', function () {
        $router = Mockery::mock(Router::class);
        $router->shouldReceive('get')->andReturn('DefaultApi::about');
        $app = new App($router, new Request());
        list($class, $method) = $app->getEndpointHandler('GET', '/fizz');
        expect($class)->toHaveMethod($method);
    });

    test('get a closure when the Router returns an invalid signature as endpoint handler', function () {
        $router = Mockery::mock(Router::class);
        $router->shouldReceive('get')->andReturn('InvalidClass::method');
        $app = new App($router, new Request());
        expect($app->getEndpointHandler('GET', '/fizz'))->toBeCallable();
    });

    test('get a closure when the Router returns a bad signature as endpoint handler', function () {
        $router = Mockery::mock(Router::class);
        $router->shouldReceive('get')->andReturn('InvalidValue');
        $app = new App($router, new Request());
        expect($app->getEndpointHandler('GET', '/fizz'))->toBeCallable();
    });

    test('get the correct payload from the Request object', function () {
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('getPayload')->andReturn(['fizz' => 'buzz']);
        $app = new App(new Router(), $request);
        expect($app->payload())->toBe(['fizz' => 'buzz']);
    });

});
