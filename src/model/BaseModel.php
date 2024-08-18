<?php

namespace VotingPlatform\model;

abstract class BaseModel
{

    private int $id;
    private string $createdAt;
    private string $updatedAt;

    /**
     * @param int $id
     * @param string $createdAt
     * @param string $updatedAt
     */
    public function __construct(int $id, string $createdAt, string $updatedAt)
    {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): BaseModel
    {
        $this->id = $id;
        return $this;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): BaseModel
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt): BaseModel
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

}