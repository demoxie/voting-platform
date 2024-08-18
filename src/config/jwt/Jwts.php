<?php

namespace VotingPlatform\config\jwt;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use VotingPlatform\config\env\Env;
use stdClass;
use VotingPlatform\exceptions\APIException;

class Jwts
{
    public static function sign($userDetails): string{
        $issuedAt = time();
        $expirationTime = $issuedAt + intval(Env::get("EXPIRATION_TIME"));
        $payload = [
            'iss' => Env::get("ISSUER"),
            'aud' => Env::get("AUDIENCE"),
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'data' => $userDetails,
        ];
        return JWT::encode($payload, Env::get("SECRET_KEY"), Env::get("ALGORITHM"));
    }

    /**
     * @throws APIException
     */
    public static function decode($jwt): array{
        try {
            $headers = new stdClass();
            $decoded = JWT::decode($jwt, new Key(Env::get("SECRET_KEY"), Env::get("ALGORITHM")), $headers);
            return (array)$decoded->data;
        } catch (\Exception $e) {
            throw new APIException("Could not decode token: ".$e->getMessage(), 500);
        }
    }

    /**
     * @throws APIException
     */
    public static function validateToken($jwt): bool{
        try {
            $headers = new stdClass();
            JWT::decode($jwt, new Key(Env::get("SECRET_KEY"), Env::get("ALGORITHM")), $headers);
            return true;
        } catch (\Exception $e) {
            throw new APIException("Invalid token: " . $e->getMessage(), 400);
        }
    }
}