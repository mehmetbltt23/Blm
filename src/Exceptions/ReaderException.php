<?php

namespace Mehmetb\BLM\Exceptions;

class ReaderException extends BLMException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}