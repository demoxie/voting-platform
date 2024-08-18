<?php

namespace VotingPlatform\repository;

require_once __DIR__.'/../constants/Constants.php';

use VotingPlatform\config\db\DbConfig;
use VotingPlatform\config\queries\QuerySelector;
use VotingPlatform\exceptions\APIException;
use VotingPlatform\model\User;
use function MongoDB\BSON\toJSON;

trait UserRepository
{
    private DbConfig $config;
    use QuerySelector;

    public function __construct()
    {
        $this->config = new DbConfig();
    }

    /**
     * @throws APIException
     */
    public function findUserById(int $id): User|bool
    {
        $queryName = "GET_USER_BY_ID";
        $placeholders = [
            'id' => $id,
            'tableName' => 'users',
        ];
        return $this->buildQuery($queryName, $placeholders);
    }
    /**
     * @throws APIException
     */
    public function findAll(): array
    {
        $queryName = "GET_ALL_USERS";
        $placeholders = [
            'tableName' => 'users',
        ];
        $result =  $this->buildQueryForMany($queryName, $placeholders);
        if (!$result) {
            throw new APIException('No users found', 404);
        }
        $users = [];
        foreach ($result as $userRow){
            //pretty print the json
            $users[] = [
                'id' => $userRow['id'],
                'name' => $userRow['name'],
                'username' => $userRow['username'],
                'email' => $userRow['email'],
                'created_at' => $userRow['created_at'],
                'updated_at' => $userRow['updated_at']
            ];
        }

        return $users;
    }

    /**
     * @throws APIException
     */
    public function getUserByEmail(string $email): ?User
    {
        $queryName = "GET_USER_BY_EMAIL";
        $placeholders = [
            'email' => $email,
            'tableName' => 'users',
        ];
        return $this->buildQuery($queryName, $placeholders);
    }

    /**
     * @throws APIException
     */
    public function save(array $userData): ?User
    {
        $queryName = "CREATE_USER";
        $placeholders = [
            'name' => $userData['name'],
            'username' => $userData['username'],
            'email' => $userData['email'],
            'password' => password_hash($userData['password'], PASSWORD_DEFAULT),
            'tableName' => 'users',
            'createdAt' => date(DATETIME_FORMAT),
            'updatedAt' => date(DATETIME_FORMAT),
        ];

        return $this->buildQuery($queryName, $placeholders);
    }

    /**
     * @throws APIException
     */
    public function updateUser(int $id, array $userData): ?User
    {
        $queryName = "UPDATE_USER";
        $placeholders = [
            'id' => $id,
            'name' => $userData['name'],
            'username' => $userData['username'],
            'email' => $userData['email'],
            'tableName' => 'users',
            'updatedAt' => date(DATETIME_FORMAT),
        ];

        return $this->buildQuery($queryName, $placeholders);
    }

    public function deleteUser(int $id): bool
    {
        $queryName = "DELETE_USER";
        $placeholders = [
            'id' => $id,
            'tableName' => 'users',
        ];

        $query = $this->getQuery($queryName, $placeholders);
        $conn = $this->config->getDbConnection();
        $stmt = $conn->prepare($query);
        return $stmt->execute();
    }

    /**
     * @param string $queryName
     * @param array $placeholders
     * @return User|bool
     * @throws APIException
     */
    private function buildQuery(string $queryName, array $placeholders): User|bool
    {
        try {
            $query = $this->getQuery($queryName, $placeholders);
            $conn = $this->config->getDbConnection();
            $stmt = $conn->prepare($query);
            $stmt->execute();

            // Handle INSERT queries
            if (str_starts_with(strtoupper($query), 'INSERT')) {
                $id = $conn->lastInsertId();
                $userQuery = $this->getQuery("GET_USER_BY_ID", ['id' => $id, 'tableName' => 'users']);
                $stmt = $conn->prepare($userQuery);
                $stmt->execute();
                $result = $stmt->fetch();
                return $result !== false ? new User(
                    $result['id'], $result['name'], $result['username'],
                    $result['email'], $result['password'],
                    $result['created_at'], $result['updated_at']
                ) : false;
            }

            // Handle SELECT queries
            if (str_starts_with(strtoupper($query), 'SELECT')) {
                $result = $stmt->fetch();
                return $result !== false ? new User(
                    $result['id'], $result['name'], $result['username'],
                    $result['email'], $result['password'],
                    $result['created_at'], $result['updated_at']
                ) : false;
            }

            // Handle UPDATE queries
            if (str_starts_with(strtoupper($query), 'UPDATE')) {
                // Assuming the update query also returns the updated record
                $id = $placeholders['id']; // Ensure 'id' is in placeholders for this operation
                $userQuery = $this->getQuery("GET_USER_BY_ID", ['id' => $id, 'tableName' => 'users']);
                $stmt = $conn->prepare($userQuery);
                $stmt->execute();
                $result = $stmt->fetch();
                return $result !== false ? new User(
                    $result['id'], $result['name'], $result['username'],
                    $result['email'], $result['password'],
                    $result['created_at'], $result['updated_at']
                ) : false;
            }

            // Handle DELETE queries
            if (str_starts_with(strtoupper($query), 'DELETE')) {
                $affectedRows = $stmt->rowCount();
                return $affectedRows > 0;
            }

            // If the query type is not recognized, throw an exception
            throw new APIException("Unknown query type: " . $queryName, 500);

        } catch (\Exception $e) {
            if (str_contains($e->getMessage(),"Duplicate")){
                throw new APIException("Record already exists", 409);
            }
            throw new APIException("Error building query: " . $e->getMessage(), 500);
        }
    }
    // build query for many

    /**
     * @param string $queryName
     * @param array $placeholders
     * @return bool|array
     * @throws APIException
     */
    public function buildQueryForMany(string $queryName, array $placeholders): bool|array
    {
        try {
            $query = $this->getQuery($queryName, $placeholders);
            $conn = $this->config->getDbConnection();
            $stmt = $conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\Exception $e) {
            throw new APIException("Error building query: ". $e->getMessage(), 500);
        }
    }
}
