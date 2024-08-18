<?php

namespace VotingPlatform\service;

use VotingPlatform\dto\SignupRequest;
use VotingPlatform\dto\UserDetails;
use VotingPlatform\model\User;

interface IUserService
{
    public function getAllUsers(): array;
    public function createUser(array $request): UserDetails;
    public function getUserById(int $userId): UserDetails;
    public function updateUser(int $userId, $data): UserDetails;
    public function deleteUser(int $userId): mixed;
}