<?php

namespace OpenChat;

class Request {

    private $payload;
    private $path;
    private $method;

    function __construct() {
        $this->payload = json_decode(file_get_contents('php://input'), 1);
        $this->path = !empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        $this->method = !empty($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '';
    }

    public function setPayload($payload) {
        $this->payload = $payload;
    }

    public function getPayload() {
        return $this->payload;
    }

    public function setPath($path) {
        $this->path = $path;
    }

    public function getPath() {
        return $this->path;
    }

    public function setMethod($method) {
        $this->method = $method;
    }

    public function getMethod() {
        return $this->method;
    }

}