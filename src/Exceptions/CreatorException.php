<?php

namespace Mehmetb\BLM\Exceptions;

class CreatorException extends BLMException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}