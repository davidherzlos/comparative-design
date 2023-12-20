<?php

namespace OpenChat;

class App {

    private $responseCode = 200;

    function __construct($router) {
        $this->router = $router;
    }

    public function registerEndpoint($method, $path, $handler) {
        $this->router->add($method, trim($path, '/'), $handler);
    }

    public function dispatch($method, $uri = 'home') {
        $handler = $this->router->get($method, trim($uri, '/'));
        if (!is_callable($handler)) {
            $this->responseCode = 404;
            return ['ok' => false, 'message' => 'page not found'];
        }

        return call_user_func($handler);
    }

    public function start() {
        $response = $this->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($this->responseCode);
        echo json_encode($response);
    }

    public static function instance($router) {
        $app = new self($router);
        require __DIR__ . '/../config/endpoints.php';
        return $app;
    }

}
