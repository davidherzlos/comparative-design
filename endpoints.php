<?php

/**
 * Sample endpoints.
 */
$app->register('GET', '/', 'SampleApi::home');

/**
 * Custom endpoints.
 */
$app->register('POST', '/users', 'UsersApi::createUser');