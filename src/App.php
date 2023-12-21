<?php

namespace OpenChat;

class App {

    function __construct($router) {
        $this->router = $router;
    }

    public function registerEndpoint($method, $path, $handler) {
        $this->router->add($method, trim($path, '/'), $handler);
    }

    public function dispatch($method, $uri = 'home') {
        $handler = $this->router->get($method, trim($uri, '/'));

        if (is_string($handler)) {
            $handler = '\\OpenChat\\UseCase\\'.$handler;
            list($class, $method) = explode('::', $handler);
            if (method_exists($class, $method)) {
                $instance = new $class();
                return $instance->$method();
            }
        }

        if (is_callable($handler)) {
            return call_user_func($handler);
        }

        return ['statusCode' => 404, 'data' => ['message' => 'page not found']];
    }

    public function start() {
        $response = $this->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
        $statusCode = !empty($response['statusCode']) ? $response['statusCode'] : 200;
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($statusCode);
        echo json_encode($response['data']);
    }

    public static function instance($router) {
        $app = new self($router);
        require __DIR__ . '/../config/endpoints.php';
        return $app;
    }

}
