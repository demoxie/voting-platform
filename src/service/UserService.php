<?php

namespace VotingPlatform\service;

use VotingPlatform\config\db\DbConfig;
use VotingPlatform\config\queries\QuerySelector;
use VotingPlatform\dto\SignupRequest;
use VotingPlatform\dto\UserDetails;
use VotingPlatform\exceptions\APIException;
use VotingPlatform\repository\UserRepository;
use VotingPlatform\service\IUserService;

class UserService implements IUserService
{
    private DbConfig $config;
    use QuerySelector;
    use UserRepository;
    public function __construct(){
        $this->config = new DbConfig();
    }

    /**
     * @throws APIException
     */
    public function getAllUsers(): array
    {
        return $this->findAll();
    }

    /**
     * @throws APIException
     * @throws \Exception
     */
    public function getUserById(int $userId): UserDetails
    {
        $user =  $this->findUserById($userId);
        if (!$user) {
            throw new APIException("User not found", 404);
        }

        return new UserDetails(
            $user->getId(),
            $user->getName(),
            $user->getUsername(),
            $user->getEmail(),
            "",
            $user->getCreatedAt(),
            $user->getUpdatedAt()
        );
    }

    public function updateUser($userId, $data): UserDetails
    {
        // TODO: Implement updateUser() method.
    }

    public function deleteUser($userId): mixed
    {
        // TODO: Implement deleteUser() method.
    }

    /**
     * @throws APIException
     */
    public function createUser(array $request): UserDetails{
        $newUser = $this->save($request);
        if (!$newUser) {
            throw new APIException("Failed to create user", 500);
        }

        return new UserDetails(
            $newUser->getId(),
            $newUser->getName(),
            $newUser->getUsername(),
            $newUser->getEmail(),
            "",
            $newUser->getCreatedAt(),
            $newUser->getUpdatedAt()
        );
    }

}