<?php

namespace OpenChat\UseCase;

use OpenChat\Domain\UserService;
use OpenChat\Request;
use OpenChat\Exception\UsernameAlreadyUsedException;

class UsersApi {

    protected UserService $userService;

    function __construct(UserService $userService = new UserService()) {
        $this->userService = $userService;
    }

    public function createUser(Request $request): array {
        try {
            $user = $this->userService->createUser($request->getPayload());
            return ['statusCode' => 201, 'data' => $user];
        } catch(UsernameAlreadyUsedException $e) {
            return ['statusCode' => 400, 'data' => ['error' => $e->getMessage()]];
        }
        
    }

}
