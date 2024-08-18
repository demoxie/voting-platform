<?php

namespace VotingPlatform\enums;

enum Gender: string
{
    case MALE = 'male';
    case FEMALE = 'female';
    case OTHER = 'other';
    case UNSPECIFIED = 'unspecified';

    private static function getGenderList(): array
    {
        return [
            self::MALE->value => 'Male',
            self::FEMALE->value => 'Female',
            self::OTHER->value => 'Other',
            self::UNSPECIFIED->value => 'Unspecified',
        ];
    }

    public function toArray(): array
    {
        return [
            'value' => $this->value,
            'label' => $this->getLabel(),
        ];
    }

    public function getLabel(): string
    {
        return self::getGenderList()[$this->value] ?? 'Unknown';
    }

    public static function fromString(string $gender): Gender{
        return match ($gender) {
            'male' => self::MALE,
            'female' => self::FEMALE,
            'other' => self::OTHER,
            'unspecified' => self::UNSPECIFIED,
            default => throw new \InvalidArgumentException('Invalid gender'),
        };
    }
}
