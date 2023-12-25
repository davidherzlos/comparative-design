<?php

namespace OpenChat\UseCase;
use OpenChat\Request;

class SampleApi {

    public function home(Request $request) {
        return ['statusCode' => 200, 'data' => ['page' => 'home']];
    }

}