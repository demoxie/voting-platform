<?php

namespace VotingPlatform\middleware;

class ValidateMethod
{
    public static function validate(string $allowedMethod, callable $next): \Closure
    {
        return function() use ($allowedMethod, $next) {
            $currentMethod = $_SERVER['REQUEST_METHOD'];
            if ($currentMethod !== $allowedMethod) {
                header('HTTP/1.1 405 Method Not Allowed');
                echo "405 Method Not Allowed: Expected $allowedMethod, got $currentMethod";
                exit;
            }

            $next();

        };
    }


}