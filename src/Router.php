<?php

namespace OpenChat;

class Router {

    public $routes;

    function __construct() {
        $this->routes = ['GET' => [], 'POST' => []];
    }

    public function add($method, $key, $handler) {
        $this->routes[$method][$key] = $handler;
    }

    public function count() {
        return count($this->routes['GET']) + count($this->routes['POST']);
    }

    public function get($method, $key) {
        if (empty($this->routes[$method][$key])) {
            return null;
        }

        return $this->routes[$method][$key];
    }

}