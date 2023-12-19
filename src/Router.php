<?php

namespace OpenChat;

class Router {

    public $routes;

    function __construct() {
        $this->routes = [];
    }

    public static function load() {
        $router = new self();
        require __DIR__ . '/../config/routes.php';
        return $router;
    }

    public function add($key, $callback) {
        $this->routes[$key] = $callback;
    }

    public function getHandler($key) {
        if (empty($this->routes[$key])) {
            return function () {
                return [];
            };
        }

        return $this->routes[$key];
    }

}