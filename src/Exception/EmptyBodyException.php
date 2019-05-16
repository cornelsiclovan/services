<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 15.05.2019
 * Time: 11:30
 */

namespace App\Exception;

use Throwable;

class EmptyBodyException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('The body of the POST/PUT method cannot be empty.', $code, $previous);
    }

}