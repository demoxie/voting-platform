<?php

namespace VotingPlatform\dto;

class LoginRequest
{
    public string $email;
    public string $password;
    public bool $rememberMe;
    public function __construct(array $data){
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->rememberMe = isset($data['rememberMe']) && $data['rememberMe'] === 'true';
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): LoginRequest
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): LoginRequest
    {
        $this->password = $password;
        return $this;
    }

    public function validate(): array {
        $errors = [];
        if (empty($this->email)) {
            $errors['email'] = 'Email is required';
        }
        if (empty($this->password)) {
            $errors['password'] = 'Password is required';
        }
        return $errors;
    }


}