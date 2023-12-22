<?php

use OpenChat\Request;

describe('Request should', function () {

    test('return the request payload as an array', function () {
        $request = new Request();
        $request->setPayload(['fizz' => 'buzz']);
        expect($request->getPayload())->toBe(['fizz' => 'buzz']);
    });

    test('return the request path', function () {
        $request = new Request();
        $request->setPath(['fizz' => 'buzz']);
        expect($request->getPath())->toBe(['fizz' => 'buzz']);
    });

    test('return the request method', function () {
        $request = new Request();
        $request->setMethod(['fizz' => 'buzz']);
        expect($request->getMethod())->toBe(['fizz' => 'buzz']);
    });

});


