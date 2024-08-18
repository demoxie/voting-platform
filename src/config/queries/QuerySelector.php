<?php

namespace VotingPlatform\config\queries;

//Read sql query from .json file and pass placeholder values

trait QuerySelector
{
    public function getQuery(string $queryName, array $placeholders): string
    {
        $queries = json_decode(file_get_contents(__DIR__. '/sql-queries.json'), true);
        $query = $queries[$queryName];
        foreach ($placeholders as $placeholder => $value) {
            $query = str_replace(':'.$placeholder, $value, $query);
        }
        return $query;
    }
}