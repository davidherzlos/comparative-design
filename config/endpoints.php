<?php

/**
 * Default endpoint, don't remove unless you dont want it anymore.
 */
$app->registerEndpointHandler('GET', '/', function () {
    return [
        'statusCode' => 200,
        'data' => [
            'message' => 'home page'
            ]
        ];
});

$app->registerEndpointHandler('GET', '/about', 'DefaultApi::about');

/**
 * Custom UseCase endpoints.
 */

$app->registerEndpointHandler('POST', '/users', 'UsersApi::createUser');
