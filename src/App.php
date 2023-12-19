<?php

namespace OpenChat;

class App {

    function __construct($router) {
        $this->router = $router;
    }

    public function dispatch($uri = 'home') {
        $handler = $this->router->getHandler(trim($uri, '/'));
        return call_user_func($handler) ;
    }

}
