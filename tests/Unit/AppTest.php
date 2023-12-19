<?php

use OpenChat\Router;
use OpenChat\App;

it('calls the router with the uri passed in the message', function () {
    $router = Mockery::mock(Router::class);
    $router->shouldReceive('getHandler')->with('home')->AndReturn(function () {
        return [];
    });
    $app = new App($router);
    expect($app->dispatch('home'))->toBeArray();
});

it('trims the hashes from the uri passed in the message', function () {
    $router = Mockery::mock(Router::class);
    $router->shouldReceive('getHandler')->with('home')->AndReturn(function () {
        return [];
    });
    $app = new App($router);
    expect($app->dispatch('/home'))->toBeArray();
});

it('calls the router with a default when the message is invalid', function () {
    $router = Mockery::mock(Router::class);
    $router->shouldReceive('getHandler')->with('home')->AndReturn(function () {
        return [];
    });
    $app = new App($router);
    expect($app->dispatch())->toBeArray();
});

// Suena atractivo inspeccionar los objetos en los tests mediante mocks.
// Pero no veo como es que es util mockear como llame el metodo y que resultado obtuve.
// Eso es algo bueno de ver en los videos y el libro.
// Estoy entrando en el mock hell, creo.
