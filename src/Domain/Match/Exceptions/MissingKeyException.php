<?php

namespace App\Domain\Match\Exceptions;

use Exception;


class MissingKeyException extends Exception
{
    public function __construct(String $key, $code = 0)
    {
        $message = 'Key ' . $key . ' is missing from the array';
        parent::__construct($message, $code, null);
    }
}
