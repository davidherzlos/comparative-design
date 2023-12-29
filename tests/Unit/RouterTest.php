<?php

use OpenChat\Router;
use OpenChat\Request;

describe('Router should', function () {

    test('add a new route', function () {
        $router = new Router();

        $router->add('GET', '/foo', fn() => true);
        expect($router)->toHaveCount(1);

        $router->add('POST', '/bar', fn() => true);
        expect($router)->toHaveCount(2);
    });
    
    test('validate routes')->todo();

    test('trim slashes when adding routes', function () {
        $router = new Router();
        $router->add('POST', '/foo', 'FooClass::method');
        expect($router->get('POST', 'foo'))->toBe('FooClass::method');
    });

    test('ignore trimming when adding the default route', function () {
        $router = new Router();
        $router->add('GET', '/', 'FooClass::method');
        expect($router->get('GET', '/'))->toBe('FooClass::method');
    });

    test('trim slashes when geting routes', function () {
        $router = new Router();
        $router->add('POST', 'foo', 'FooClass::method');
        expect($router->get('POST', '/foo'))->toBe('FooClass::method');
    });

    test('ignore trimming when getting the default route', function () {
        $router = new Router();
        $router->add('GET', '/', 'FooClass::method');
        expect($router->get('GET', '/'))->toBe('FooClass::method');
    });

    test('return null when the route does not exist', function () {
        $router = new Router();
        expect($router->get('GET', '/foo'))->toBe(null);
    });

    test('get a handler from the request parameters', function () {
        $requestMock = Mockery::mock(Request::class);
        $requestMock->shouldReceive('getMethod');
        $requestMock->shouldReceive('getUri');
        $router = new Router();
        $router->getHandler($requestMock);
    });

    test('return a callable object when the handler is a closure', function () {
        $requestMock = Mockery::mock(Request::class);
        $requestMock->shouldReceive('getMethod')->andReturn('POST');
        $requestMock->shouldReceive('getUri')->andReturn('/foo');
        $router = new Router();
        $router->add('POST', '/foo', fn() => true);
        $handler = $router->getHandler($requestMock);
        expect($handler)->toBeCallable();
    });

    test('return a callable object when the handler is not found', function () {
        $requestMock = Mockery::mock(Request::class);
        $requestMock->shouldReceive('getMethod')->andReturn('POST');
        $requestMock->shouldReceive('getUri')->andReturn('/foo');
        $router = new Router();
        $handler = $router->getHandler($requestMock);
        expect($handler)->toBeCallable();
    });

    test('return a callable object when the handler is asked incorrectly', function () {
        $requestMock = Mockery::mock(Request::class);
        $requestMock->shouldReceive('getMethod');
        $requestMock->shouldReceive('getUri');
        $router = new Router();
        $handler = $router->getHandler($requestMock);
        expect($handler)->toBeCallable();
    });

    test('return a callable object when the handler is class path', function () {
        $requestMock = Mockery::mock(Request::class);
        $requestMock->shouldReceive('getMethod')->andReturn('POST');
        $requestMock->shouldReceive('getUri')->andReturn('/foo');
        $router = new Router();
        $router->add('POST', '/foo', 'SampleApi::home');
        $handler = $router->getHandler($requestMock);
        expect($handler)->toBeCallable();
    });

    test('return a callable when the handler is an invalid class', function () {
        $requestMock = Mockery::mock(Request::class);
        $requestMock->shouldReceive('getMethod')->andReturn('POST');
        $requestMock->shouldReceive('getUri')->andReturn('/foo');
        $router = new Router();
        $router->add('POST', '/foo', 'InvalidApi::foo');
        $handler = $router->getHandler($requestMock);
        expect($handler)->toBeCallable();
    });

});


