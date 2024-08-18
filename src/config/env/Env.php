<?php

namespace VotingPlatform\config\env;
require_once __DIR__.'/../../../vendor/autoload.php';

use Dotenv\Dotenv;


class Env
{

    public static function get(string $key): string{
        $dotenv = Dotenv::createImmutable(__DIR__ .'/../../../');
        $dotenv->load();
        return $_ENV[$key];
    }
}