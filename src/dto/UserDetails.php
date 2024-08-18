<?php

namespace VotingPlatform\dto;

class UserDetails implements \JsonSerializable
{
    private int $id;
    private string $name;
    private string $username;
    private string $email;
    private string $token;
    private string $createdAt;
    private string $updatedAt;

    /**
     * @param int $id
     * @param string $name
     * @param string $username
     * @param string $email
     * @param string $token
     * @param string $created_at
     * @param string $updated_at
     */
    public function __construct(int $id, string $name, string $username, string $email, string $token, string $created_at, string $updated_at)
    {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
        $this->email = $email;
        $this->token = empty($token) ? "" : $token;
        $this->createdAt = $created_at;
        $this->updatedAt = $updated_at;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): UserDetails
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): UserDetails
    {
        $this->name = $name;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): UserDetails
    {
        $this->username = $username;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): UserDetails
    {
        $this->email = $email;
        return $this;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): UserDetails
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): UserDetails
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function __toString(): string
    {
        return json_encode($this->toArray());
    }

    private function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'token' => $this->token,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }


    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}