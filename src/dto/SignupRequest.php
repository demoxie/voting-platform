<?php

namespace VotingPlatform\dto;

use VotingPlatform\model\Role;

class SignupRequest
{
    private string $name;
    private string $username;
    private string $email;
    private string $password;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->username = $data['username'];
        $this->email = $data['email'];
        $this->password = $data['password'];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): SignupRequest
    {
        $this->name = $name;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): SignupRequest
    {
        $this->username = $username;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): SignupRequest
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): SignupRequest
    {
        $this->password = $password;
        return $this;
    }

    public function __toString(): string
    {
        return json_encode($this->toArray());
    }

    private function toArray(): array
    {
        return [
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }


}