<?php

namespace VotingPlatform\controller;

use VotingPlatform\dto\UserDetails;
use VotingPlatform\exceptions\APIException;
use VotingPlatform\service\IUserService;
use VotingPlatform\service\UserService;

class UserController
{
    private IUserService $userService;
    public function __construct() {
        $this->userService = new UserService();
    }

    /**
     * @throws APIException
     */
    public function getUserById(int $data): UserDetails
    {
        return $this->userService->getUserById($data);
    }

    /**
     * @throws APIException
     */
    public function getUsers(): array
    {
        return $this->userService->getAllUsers();
    }

    /**
     * @throws APIException
     */
    public function createUser(array $data): UserDetails{
        return $this->userService->createUser($data);
    }
}