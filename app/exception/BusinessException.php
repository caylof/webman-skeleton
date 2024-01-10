<?php

namespace app\exception;

class BusinessException extends \Exception
{
    public int $status = 423;

    public function __construct(string $message = '', int $status = 423)
    {
        parent::__construct($message);
        $this->status = $status;
    }
}
