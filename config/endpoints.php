<?php

/**
 * Default endpoint, don't remove unless you dont want it anymore.
 */
$app->registerEndpoint('GET', '/', function () {
    return [
        'statusCode' => 200,
        'data' => [
            'message' => 'home page'
            ]
        ];
});

$app->registerEndpoint('GET', '/about', 'DefaultApi::about');

/**
 * User custom endpoints.
 */

$app->registerEndpoint('POST', '/users', 'UserApi::create_user');
