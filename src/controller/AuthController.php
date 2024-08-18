<?php

namespace VotingPlatform\controller;

use VotingPlatform\dto\LoginRequest;
use VotingPlatform\dto\SignupRequest;
use VotingPlatform\dto\UserDetails;
use VotingPlatform\exceptions\APIException;
use VotingPlatform\service\AuthService;
use VotingPlatform\service\IAuthService;

class AuthController
{
    private IAuthService $auth;

    public function __construct() {
        $this->auth =new AuthService();
    }

    /**
     * @param array $request
     * @return mixed
     * @throws APIException
     */
    public function authenticateUser(array $request): mixed {
        $loginRequest = new LoginRequest($request);

        return $this->auth->authenticateUser($loginRequest);
    }

    /**
     * @param $request
     * @return UserDetails
     * @throws APIException
     */
    public function signup($request): UserDetails {
        $signupRequest = new SignupRequest($request);
        return $this->auth->signup($signupRequest);
    }
}