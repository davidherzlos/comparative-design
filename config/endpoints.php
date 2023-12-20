<?php

/**
 * Default endpoint, don't remove unless you dont want it anymore.
 */
$app->registerEndpoint('GET', '/home', fn() => ['ok' => true, 'message' => 'im the home page']);

/**
 * User custom endpoints.
 */

$app->registerEndpoint('GET', '/users', fn() => ['ok' => true, 'users' => []]);
