<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.05.2019
 * Time: 11:48
 */

namespace App\Exception;
use Throwable;

class InvalidUserException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('User is invalid.', $code, $previous);
    }

}