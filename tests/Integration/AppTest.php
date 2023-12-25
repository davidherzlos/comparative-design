<?php

use OpenChat\Router;
use OpenChat\Request;
use OpenChat\App;
use OpenChat\UseCase\SampleApi;

describe('App should', function () {

    test('add an endpoint handler to the Router', function () {
        $router = Mockery::mock(Router::class);
        $router->shouldReceive('add')->withArgs(
            fn($arg1, $arg2, $arg3) => $arg1 == 'POST' && $arg2 == '/foo' && is_callable($arg3)
        );
        $app = new App($router);
        $app->registerEndpointHandler('POST', '/foo', fn() => ['foo' => 'bar']);
    });

    test('get an endpoint handler from the Router', function () {
        $request = new Request();
        $routerMock = Mockery::mock(Router::class);
        $routerMock->shouldReceive('getHandler')->with($request);
        $app = new App($routerMock);
        $app->dispatch($request);
    });

    test('use the closure returned by the Router as the handler', function () {
        $routerMock = Mockery::mock(Router::class);
        $routerMock->shouldReceive('getHandler')->andReturn(fn() => ['statusCode' => 303]);
        $app = new App($routerMock);
        expect($app->dispatch(new Request()))->toMatchArray(['statusCode' => 303]);
    });

    test('use the method mapped by the Router as the handler', function () {
        $routerMock = Mockery::mock(Router::class);
        $routerMock->shouldReceive('getHandler')->andReturn('SampleApi::home');
        $request = new Request();
        $sampleApi = Mockery::mock(SampleApi::class);
        $sampleApi->shouldReceive('home')->with($request);
        $app = new App($routerMock);
        $app->dispatch($request);
    });

    test('use a 404 closure as handler when the Router maps to nothing', function () {
        $routerMock = Mockery::mock(Router::class);
        $routerMock->shouldReceive('getHandler')->andReturn(null);
        $app = new App($routerMock);
        expect($app->dispatch(new Request))->toMatchArray(['statusCode' => 404]);
    });

    test('use a 404 closure as handler when the Router maps to a missing class', function () {
        $routerMock = Mockery::mock(Router::class);
        $routerMock->shouldReceive('getHandler')->andReturn('InvalidClass::method');

        $app = new App($routerMock);
        expect($app->dispatch(new Request()))->toMatchArray(['statusCode' => 404]);
    });

    test('use a 404 closure as handler when the Router maps to an invalid class', function () {
        $routerMock = Mockery::mock(Router::class);
        $routerMock->shouldReceive('getHandler')->andReturn('foo');

        $app = new App($routerMock);
        expect($app->dispatch(new Request()))->toMatchArray(['statusCode' => 404]);
    });

});

