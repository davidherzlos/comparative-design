<?php

use OpenChat\Request;
use OpenChat\UseCase\UsersApi;
use OpenChat\Domain\UserService;
use OpenChat\Exception\UsernameAlreadyUsedException;

describe('UsersApi should', function () {

    test('create a new user', function () {
        $registrationData = [
            'username' => 'david',
            'password' => '061685',
            'about' => 'london school is hard'
        ];
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('getPayload')->andReturn($registrationData);
        $service = Mockery::spy(UserService::class);

        $usersApi = new UsersApi($service);
        $usersApi->createUser($request);
        
        $service->shouldHaveReceived('createUser')->with($registrationData);

    });

    test('return an array representing a newly created user', function () {
        $registrationData = [
            'username' => 'david',
            'password' => '061685',
            'about' => 'london school is hard'
        ];
        $service = Mockery::mock(UserService::class);
        $service->shouldReceive('createUser')->andReturn($registrationData);
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('getPayload')->andReturn($registrationData);
        
        $usersApi = new UsersApi($service);
        $result = $usersApi->createUser($request);
        
        expect($result['statusCode'])->toBe(201);
        expect($result['data'])->toMatchArray($registrationData);
    });
    
    test('return an error when creating a user with an existing username', function () {
        $registrationData = [
            'username' => 'david',
            'password' => '061685',
            'about' => 'london school is hard'
        ];
        $service = Mockery::mock(UserService::class);
        $service->shouldReceive('createUser')->andThrow(new UsernameAlreadyUsedException('Username is already in use'));
        $request = Mockery::mock(Request::class);
        $request->shouldReceive('getPayload')->andReturn($registrationData);
        
        $usersApi = new UsersApi($service);
        $result = $usersApi->createUser($request);
        
        expect($result['statusCode'])->toBe(400);
        expect($result['data'])->toMatchArray(['error' => 'Username is already in use']);
    });

});
