<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.05.2019
 * Time: 11:49
 */

namespace App\Exception;
use Throwable;

class InvalidConfirmationTokenException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct("Confirmation token is invalid.", $code, $previous);
    }

}