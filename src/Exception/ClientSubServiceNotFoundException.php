<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 24.06.2019
 * Time: 15:25
 */

namespace App\Exception;
use Throwable;

class ClientSubServiceNotFoundException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('You do not have access to this resource', $code, $previous);
    }
}