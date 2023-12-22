<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Symfony\Component\HttpClient\HttpClient;

abstract class TestCase extends BaseTestCase {

    protected function setUp(): void {
        $client = HttpClient::create();
        $this->httpClient = $client->withOptions(['base_uri' => 'http://localhost:8080']);
    }

    protected function tearDown(): void {
        $this->httpClient = null;
    }

}
