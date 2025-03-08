<?php

namespace App\Exceptions;

use Exception;

class ParsingException extends Exception
{
    public function __construct(string $message, int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function render($request)
    {
        return response()->json([
            'error' => 'Parsing error',
            'message' => $this->getMessage(),
        ], 500);
    }
}