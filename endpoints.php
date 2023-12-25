<?php

/**
 * Sample endpoints.
 */
$app->registerEndpointHandler('GET', '/', 'SampleApi::home');

/**
 * Custom endpoints.
 */
$app->registerEndpointHandler('POST', '/users', 'UsersApi::createUser');
