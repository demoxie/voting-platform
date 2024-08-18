<?php

namespace VotingPlatform\model;

class User extends BaseModel
{
    private string $name;
    private string $username;
    private string $password;
    private string $email;

    /**
     * @param int $id
     * @param string $name
     * @param string $username
     * @param string $email
     * @param string $password
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(
        int $id,
        string $name,
        string $username,
        string $email,
        string $password,
        string $createdAt,
        string $updatedAt
    ) {
        // Call the parent constructor to initialize BaseModel properties
        parent::__construct($id, $createdAt, $updatedAt);

        // Initialize User-specific properties
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }


    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): User
    {
        $this->username = $username;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): User
    {
        //hash password before setting it
        $this->password = $password;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }


}