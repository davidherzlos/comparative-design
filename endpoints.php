<?php

/**
 * Sample endpoints.
 */
$app->registerEndpointHandler('GET', '/', function () {
    return ['statusCode' => 200, 'data' => ['message' => 'home page']];
});

$app->registerEndpointHandler('GET', '/about', 'DefaultApi::about');

/**
 * Custom endpoints.
 */

$app->registerEndpointHandler('POST', '/users', 'UsersApi::createUser');
