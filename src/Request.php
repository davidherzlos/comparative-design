<?php

namespace OpenChat;

class Request {

    private $method;
    private $uri;
    private $payload;

    function __construct() {
        $this->method = !empty($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '';
        $this->uri = !empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
        $this->payload = json_decode(file_get_contents('php://input'), 1);
    }

    public function setMethod($method) {
        $this->method = $method;
    }

    public function getMethod() {
        return $this->method;
    }

    public function setUri($uri) {
        $this->uri = $uri;
    }

    public function getUri() {
        return $this->uri;
    }

    public function setPayload($payload) {
        $this->payload = $payload;
    }

    public function getPayload() {
        return $this->payload;
    }

}