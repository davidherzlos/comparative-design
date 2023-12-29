<?php

use OpenChat\Router;
use OpenChat\Request;
use OpenChat\App;
use OpenChat\UseCase\SampleApi;

describe('App should', function () {

    test('add an endpoint handler to the Router', function () {
        $router = Mockery::mock(Router::class);
        $router->shouldReceive('add')->withArgs(
            function ($arg1, $arg2, $arg3) {
                return $arg1 == 'POST' && $arg2 == '/foo' && is_callable($arg3);
            }
        );;
        $app = new App($router);
        $app->register('POST', '/foo', fn() => ['foo' => 'bar']);
    });

    test('get an endpoint handler to the Router', function () {
        $routerMock = Mockery::mock(Router::class);
        $request = new Request();
        $routerMock->shouldReceive('getHandler')->with($request);
        $app = new App($routerMock);
        $app->getCallable($request);
    });

    test('return a callable value as endpoint handler', function () {
        $routerMock = Mockery::mock(Router::class);
        $routerMock->shouldReceive('getHandler')->andReturn(fn() => true);
        $app = new App($routerMock);
        expect($app->getCallable(new Request()))->toBeCallable();
    });

    test('call the expected endpoint handler', function () {
        $request = new Request();
        $routerMock = Mockery::mock(Router::class);
        $routerMock->shouldReceive('getHandler')->andReturn([new SampleApi(), 'home']);
        $sampleApiMock = Mockery::mock(SampleApi::class);
        $sampleApiMock->shouldReceive('home')->with($request);
        $app = new App($routerMock);
        $app->dispatch($request);
    });

    test('return the result from endpoint handler', function () {
        $routerMock = Mockery::mock(Router::class);
        $routerMock->shouldReceive('getHandler')->andReturn([new SampleApi(), 'home']);
        $app = new App($routerMock);
        $response = $app->dispatch(new Request());
        expect($response['data'])->toMatchArray(['page' => 'home']);
    });

});

