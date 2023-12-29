<?php

require __DIR__ . '/../vendor/autoload.php';

use OpenChat\App;
use OpenChat\Router;

$app = App::instance(new Router());
$app->start();