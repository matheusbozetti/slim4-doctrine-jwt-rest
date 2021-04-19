<?php

namespace App\Utils;

class Error
{
    public static function invalidCredentials()
    {
        throw new \Exception('Invalid Credentials', 400);
    }

    public static function invalidFormat(?string $fieldName = '')
    {
        throw new \Exception('Invalid '.$fieldName.' format', 400);
    }

    public static function fieldUsed(?string $fieldName = '')
    {
        throw new \Exception('This '.$fieldName.' has been used.', 400);
    }

    public static function userNotFound()
    {
        throw new \Exception('User not found', 400);
    }

    public static function requiredField(string $fieldName)
    {
        throw new \Exception('Field '.$fieldName.' is required!', 400);
    }

    public static function customMessage(string $message, int $statusCode)
    {
        throw new \Exception($message, $statusCode);
    }
}
