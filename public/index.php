<?php

// TODO, refine the way we deliver the responses to the browser.
// We would need some little reseach for this.
// What i really need is a way to call a rest server and let the frontend
// to consume asynchronously those apis.
require __DIR__ . '/../vendor/autoload.php';

use OpenChat\Router;
use OpenChat\App;

$app = new App(Router::load());
echo json_encode($app->dispatch($_SERVER['REQUEST_URI']));
