<?php

namespace OpenChat;

use OpenChat\Request;

class App {

    private $router;

    public static function instance($router, $request) {
        $app = new self($router, $request);
        require __DIR__ . '/../endpoints.php';
        return $app;
    }

    function __construct($router, $request) {
        $this->router = $router;
        $this->request = $request;
    }

    public function registerEndpointHandler($method, $uri, $handler) {
        $this->router->add($method, $uri, $handler);
    }

    public function dispatch() {
        $handler = $this->router->getHandler($this->request);
        $callable = $this->getCallable($handler);
        return $callable($this->request);
    }

    private function getCallable($handler) {
        return $this->mapHandlerToCallable($handler);
    }

    private function mapHandlerToCallable($handler) {
        $notFound = function () {
            return ['statusCode' => 404, 'data' => ['message' => 'page not found']];
        };

        if (empty($handler)) {
            return $notFound;
        }

        if (is_callable($handler)) {
            return $handler;
        }

        $signature = $this->getMethodSignature($handler);

        if (count($signature) !==2 || !method_exists($signature[0], $signature[1])) {
            return $notFound;
        }

        return [new $signature[0], $signature[1]];
    }

    private function getMethodSignature($handler) {
        $fullSignature = '\\OpenChat\\UseCase\\'.$handler;
        return explode('::', $fullSignature);
    }

    public function start() {
        // TODO: test side effect.
        $response = $this->dispatch();
        $statusCode = !empty($response['statusCode']) ? $response['statusCode'] : 200;
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($statusCode);
        echo json_encode($response['data']);
    }

}
