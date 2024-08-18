<?php

namespace VotingPlatform\config\redis;


use VotingPlatform\config\env\Env;
use Predis;

class Redis
{
    public static function client(): Predis\Client
    {
        return new Predis\Client([
            'scheme' => 'tcp',
            'host'   => Env::get("REDIS_HOST"),
            'port'   => Env::get("REDIS_PORT"),
            'password' => Env::get("REDIS_PASSWORD"),
        ]);
    }
}