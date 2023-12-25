<?php

namespace OpenChat;

use OpenChat\Request;

class App {

    private $router;

    public static function instance($router) {
        $app = new self($router);
        require __DIR__ . '/../endpoints.php';
        return $app;
    }

    function __construct($router) {
        $this->router = $router;
    }

    public function registerEndpointHandler($method, $uri, $handler) {
        $this->router->add($method, $uri, $handler);
    }

    public function dispatch($request) {
        $handler = $this->router->getHandler($request);
        $callable = $this->getCallable($handler);
        return $callable($request);
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
        $response = $this->dispatch(new Request());
        if (!empty($response['statusCode'])) {
            http_response_code($response['statusCode']);
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response['data']);
    }

}
