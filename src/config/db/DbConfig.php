<?php

namespace VotingPlatform\config\db;

use VotingPlatform\config\env\Env;

class DbConfig
{

    public function getDbConnection(): \PDO{
        $dsn = "mysql:host=". Env::get("DB_HOST").";dbname=". Env::get("DB_NAME");
        $user = Env::get("DB_USER");
        $password = Env::get("DB_PASSWORD");
        return new \PDO($dsn, $user, $password);
    }
}