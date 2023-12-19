<?php

// Default route, don't remove unless you know what you are doing.
$router->add('home', fn() => ['ok' => true, 'message' => 'im the home page']);

// Custom user routes.
$router->add('users', fn() => ['ok' => true, 'users' => []]);
