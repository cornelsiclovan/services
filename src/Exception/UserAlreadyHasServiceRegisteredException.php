<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23.04.2019
 * Time: 10:47
 */

namespace App\Exception;

use Throwable;

class UserAlreadyHasServiceRegisteredException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct("This user has already registerd this service", $code, $previous);
    }
}