<?php

require __DIR__ . '/../vendor/autoload.php';

use OpenChat\App;
use OpenChat\Router;
use OpenChat\Request;

$app = App::instance(new Router());
$app->start();
