<?php

namespace OpenChat;

class App {

    private $router;
    private $request;

    function __construct($router, $request) {
        $this->router = $router;
        $this->request = $request;
    }

    public function registerEndpointHandler($method, $uri, $handler) {
        $this->router->add($method, trim($uri, '/'), $handler);
    }

    public function getEndpointHandler($method, $uri) {
        $defaultClosure = fn() => ['statusCode' => 404, 'data' => ['message' => 'page not found']];
        $possibleHandler = $this->router->get($method, trim($uri, '/'));

        if (!$possibleHandler) {
            return $defaultClosure;
        }

        if (is_callable($possibleHandler)) {
            return $possibleHandler;
        }

        $signature = $this->getMethodSignature($possibleHandler);

        if (!is_array($signature) || count($signature) !== 2 || !method_exists($signature[0], $signature[1])) {
            return $defaultClosure;
        }

        return [$signature[0], $signature[1]];
    }

    public function getMethodSignature($handler) {
        $fullSignature = '\\OpenChat\\UseCase\\'.$handler;
        return explode('::', $fullSignature);
    }

    public function payload() {
        return $this->request->getPayload();
    }

    public function dispatch($method, $uri = 'home') {
        $handler = $this->getEndpointHandler($method, $uri);
        if (!is_array($handler)) {
            return call_user_func($handler);
        }
        list($class, $methodName) = $handler;
        $instance = new $class();
        return $instance->$methodName($method === 'POST' ? $this->payload() : null);
    }

    public function start() {
        $response = $this->dispatch($this->request->getMethod(), $this->request->getPath());
        $statusCode = !empty($response['statusCode']) ? $response['statusCode'] : 200;
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($statusCode);
        echo json_encode($response['data']);
    }

    public static function instance($router, $request) {
        $app = new self($router, $request);
        require __DIR__ . '/../config/endpoints.php';
        return $app;
    }

}
