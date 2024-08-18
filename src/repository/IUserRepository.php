<?php

namespace VotingPlatform\repository;

use VotingPlatform\model\User;

interface IUserRepository
{
    public function getUserById(int $id): User;
    public function getUserByEmail(string $email): User;
    public function createUser(array $userData): User;
    public function updateUser(int $id, array $userData): User;
    public function deleteUser(int $id): mixed;
}