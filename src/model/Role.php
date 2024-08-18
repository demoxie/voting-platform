<?php

namespace VotingPlatform\model;

use VotingPlatform\model\BaseModel;

class Role extends BaseModel
{
    private string $name;
    private string $description;

    public function __construct(string $name, string $description){
        $this->name = $name;
        $this->description = $description;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Role
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Role
    {
        $this->description = $description;
        return $this;
    }


}