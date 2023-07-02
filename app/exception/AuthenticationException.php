<?php

namespace app\exception;

class AuthenticationException extends \Exception
{
    public int $status = 401;
    protected $message = 'Unauthenticated';
}
