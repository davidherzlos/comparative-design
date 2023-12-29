<?php

namespace OpenChat;

class Router implements \Countable {

    public array $routes;

    function __construct() {
        $this->routes = ['GET' => [], 'POST' => []];
    }

    public function add(string $method, string $key, mixed $handler): void {
        $this->routes[$method][$this->cleanSlashes($key)] = $handler;
    }

    public function count(): int {
        return count($this->routes['GET']) + count($this->routes['POST']);
    }

    public function get(string $method, string $key): callable|string|null {
        return !empty($this->routes[$method][$this->cleanSlashes($key)])
            ? $this->routes[$method][$this->cleanSlashes($key)]
            : null;
    }

    public function getHandler(Request $request): callable {
        $default = function () {
            return ['statusCode' => 404, 'data' => ['message' => 'page not found']];
        };

        $method = $request->getMethod();
        $uri = $request->getUri();

        if (empty($method) || empty($uri)) {
            return $default;
        }

        $uri = $this->cleanSlashes($uri);
        $handler = $this->get($method, $uri);

        if (!$handler) {
            return $default;
        }

        if (is_callable($handler)) {
            return $handler;
        }

        $handler = $this->mapHandlerToCallable($handler);

        if (empty($handler)) {
            return $default;
        }

        return $handler;
    }

    private function cleanSlashes(string $token): string {
        return $token === '/' ? $token : trim($token, '/');
    }

    private function mapHandlerToCallable(string $handler): array {
        $methodPath = '\\OpenChat\\UseCase\\'.$handler;
        $parts = explode('::', $methodPath);
        if (count($parts) !== 2 || !method_exists($parts[0], $parts[1])) {
            return [];
        }

        return [new $parts[0], $parts[1]];
    }

}