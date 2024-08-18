<?php

namespace VotingPlatform\model;

use VotingPlatform\model\BaseModel;

class Vote extends BaseModel
{
    private int $candidate;
    private int $voter;
    private int $roleId;

    public function __construct(int $candidate, int $voter, int $roleId)
    {
        $this->candidate = $candidate;
        $this->voter = $voter;
        $this->roleId = $roleId;
    }

    public function getCandidate(): int
    {
        return $this->candidate;
    }

    public function setCandidate(int $candidate): Vote
    {
        $this->candidate = $candidate;
        return $this;
    }

    public function getVoter(): int
    {
        return $this->voter;
    }

    public function setVoter(int $voter): Vote
    {
        $this->voter = $voter;
        return $this;
    }

    public function getRoleId(): int
    {
        return $this->roleId;
    }

    public function setRoleId(int $roleId): Vote
    {
        $this->roleId = $roleId;
        return $this;
    }

}