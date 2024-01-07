<?php

namespace OpenChat;

class App {

    private Router $router;

    public static function instance(Router $router): self {
        $app = new self($router);
        require __DIR__ . '/../endpoints.php';
        return $app;
    }

    function __construct(Router $router) {
        $this->router = $router;
    }

    public function register(string $method, string $uri, mixed $handler): void {
        $this->router->add($method, $uri, $handler);
    }

    public function getCallable(Request $request): callable {
        return $this->router->getHandler($request);
    }

    public function dispatch(Request $request): array|null {
        $callable = $this->getCallable($request);
        return $callable($request);
    }

    public function start(): void {
        $response = $this->dispatch(new Request());
        if (!empty($response['statusCode'])) {
            http_response_code($response['statusCode']);
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response['data']);
    }

}
