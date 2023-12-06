<?php

namespace app\auth;

use Caylof\Jwt\JwtAlgo;
use Caylof\Jwt\JwtParser;
use Caylof\Jwt\JwtSigner;

class Auth extends Base
{
    public function __construct()
    {
        $this->jwtSigner = new JwtSigner(JwtAlgo::HS256, config('services.jwt.signer_key', ''));
        $this->jwtParser = new JwtParser();
    }
}
