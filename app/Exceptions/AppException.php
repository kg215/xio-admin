<?php

namespace App\Exceptions;

use Exception;


class AppException extends Exception
{
    public $status = 422;
}
