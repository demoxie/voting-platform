<?php

namespace VotingPlatform\service;

use VotingPlatform\dto\LoginRequest;
use VotingPlatform\dto\SignupRequest;
use VotingPlatform\dto\UserDetails;

interface IAuthService
{
    public function authenticateUser(LoginRequest $request): mixed;
    public function signup(SignupRequest $request): UserDetails;
}