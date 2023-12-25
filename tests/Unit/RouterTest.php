<?php

use OpenChat\Router;
use OpenChat\Request;

describe('Router should', function () {

    test('add new routes', function () {
        $router = new Router();
        $router->add('POST', '/foo', fn() => true);
        expect($router->count())->toBe(1);
    });

    test('find a stored handler given a valid request object', function () {
        $requestMock = Mockery::mock(Request::class);
        $requestMock->shouldReceive('getMethod')->andReturn('GET');
        $requestMock->shouldReceive('getUri')->andReturn('/foo');

        $router = new Router();
        $router->add('GET', 'foo', fn() => true);

        expect($router->getHandler($requestMock))->toBeCallable();
    });

    test('manage slashed when adding and getting routes', function () {
        $requestMock = Mockery::mock(Request::class);
        $requestMock->shouldReceive('getMethod')->andReturn('GET');
        $requestMock->shouldReceive('getUri')->andReturn('/');

        $router = new Router();
        $router->add('GET', '/', fn() => true);

        expect($router->getHandler($requestMock))->toBeCallable();
    });

    test('return null when the request state is invalid', function () {
        $requestMock = Mockery::mock(Request::class);
        $requestMock->shouldReceive('getMethod')->andReturn('GET');
        $requestMock->shouldReceive('getUri')->andReturn(null);

        $router = new Router();
        $router->add('GET', 'foo', fn() => true);

        expect($router->getHandler($requestMock))->toBeNull();
    });

    test('return null when a handler does not exist', function () {
        $requestMock = Mockery::mock(Request::class);
        $requestMock->shouldReceive('getMethod')->andReturn('GET');
        $requestMock->shouldReceive('getUri')->andReturn('/foo');

        $router = new Router();
        expect($router->getHandler($requestMock))->toBeNull();
    });

});


