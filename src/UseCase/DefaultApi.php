<?php

namespace OpenChat\UseCase;

class DefaultApi {

    public function about() {
        return ['statusCode' => 200, 'data' => ['message' => 'about page']];
    }

}