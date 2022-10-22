<?php

namespace Mehmetb\BLM\Exceptions;

class BLMException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}