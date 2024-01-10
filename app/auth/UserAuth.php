<?php

namespace app\auth;

use Caylof\Jwt\JwtAlgo;
use Caylof\Jwt\JwtParser;
use Caylof\Jwt\JwtSigner;

class UserAuth extends Base
{
    protected string $issuer = 'user_guard';

    public function __construct()
    {
        $this->jwtSigner = new JwtSigner(JwtAlgo::HS256, config('services.jwt.signer_key', ''));
        $this->jwtParser = new JwtParser();
    }
}
