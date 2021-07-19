<?php

namespace App\Exceptions;

use Flugg\Responder\Exceptions\Http\HttpException;

class DataNotfoundException extends HttpException
{
    /**
     * The HTTP status code.
     *
     * @var int
     */
    protected $status = 500;

    /**
     * The error code.
     *
     * @var string|null
     */
    protected $errorCode = 'data_not_found';

    /**
     * The error message.
     *
     * @var string|null
     */
    protected $message = 'Data not found.';
}
