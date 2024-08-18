<?php

namespace VotingPlatform\utils;

class Utils
{
    public static function generateRandomString($length = 10): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function generateRandomNumber($length = 6): string
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString.= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function generateUniqueIdentifier(): string
    {
        return md5(uniqid(rand(), true));
    }

    public static function generateRandomEmail($length = 8): string
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString.= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString. '@example.com';
    }
    //create a generic model mapping

    public static function mapModel($model, $data) {
        $object = new $model;
        foreach ($data as $key => $value) {
            $object->{$key} = $value;
        }
        return $object;
    }

    public static function sendJsonResponse(int $status, string $message, $data = null): void
    {
        header('Content-Type: application/json');
        echo json_encode([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], JSON_PRETTY_PRINT);
    }
}