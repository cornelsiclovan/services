<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.04.2019
 * Time: 13:37
 */

namespace App\Security;
use function max;
use function random_int;

class TokenGenerator
{
    private const ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    public function getRandomSecureToken(int $length = 30): string
    {
        $token = '';
        $maxNumber = strlen(self::ALPHABET);
        for($i = 0; $i < $length; $i++){
            $token .= self::ALPHABET[random_int(0, $maxNumber - 1)];
        }
        return $token;
    }
}