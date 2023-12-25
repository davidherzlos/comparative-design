<?php

namespace OpenChat;

use OpenChat\Request;

class Router {

    public $routes;

    function __construct() {
        $this->routes = ['GET' => [], 'POST' => []];
    }

    public function add($method, $key, $handler) {
        $this->routes[$method][$this->cleanSlashes($key)] = $handler;
    }

    private function cleanSlashes($token) {
        return $token === '/' ? $token : trim($token, '/');
    }

    public function count() {
        return count($this->routes['GET']) + count($this->routes['POST']);
    }

    public function getHandler(Request $request) {
        if (empty($request->getUri())) {
            return null;
        }

        $uri = $this->cleanSlashes($request->getUri());

        $method = $request->getMethod();

        if (empty($this->routes[$method][$uri])) {
            return null;
        }

        return $this->routes[$method][$uri];
    }

}