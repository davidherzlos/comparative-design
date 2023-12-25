<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Symfony\Component\HttpClient\HttpClient;

abstract class TestCase extends BaseTestCase {

    protected function setUp(): void {
        $this->http = HttpClient::create()->withOptions(['base_uri' => 'http://localhost:8080']);
    }

    protected function tearDown(): void {
        $this->http = null;
    }

}
