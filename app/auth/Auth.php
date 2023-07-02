<?php

namespace app\auth;

use Caylof\Jwt\JwtAlgo;
use Caylof\Jwt\JwtIssuer;
use Caylof\Jwt\JwtParser;
use Caylof\Jwt\JwtSigner;
use Caylof\Jwt\JwtValidator;
use JetBrains\PhpStorm\ArrayShape;

class Auth
{
    const TKN_TYPE_ACCESS = 'auth';
    const TKN_TYPE_REFRESH = 'refresh';

    protected string $issuer = 'user-srv';
    protected JwtSigner $jwtSigner;
    protected JwtParser $jwtParser;

    public function __construct()
    {
        $this->jwtSigner = new JwtSigner(JwtAlgo::HS256, config('services.jwt.signer_key', ''));
        $this->jwtParser = new JwtParser();
    }

    #[ArrayShape(['access_token' => 'string', 'expires_in' => 'int', 'refresh_token' => 'string'])]
    public function publish(User $user): array
    {
        $claims = ['user' => $user->toArray()];
        $accessTknExpireHours = 1;
        $accessTkn = $this->issueJwt(self::TKN_TYPE_ACCESS, $claims, [0, $accessTknExpireHours]);
        $refreshTkn = $this->issueJwt(self::TKN_TYPE_REFRESH, $claims, [10]);
        return [
            'access_token' => $accessTkn,
            'expires_in' => $accessTknExpireHours * 3600,
            'refresh_token' => $refreshTkn,
        ];
    }

    #[ArrayShape(['validated' => 'bool', 'user' => User::class])]
    public function verify(string $tknType, string $jwtStr): array
    {
        $token = $this->jwtParser->parse($jwtStr);
        $jwtValidator = new JwtValidator(
            issuer: $this->issuer,
            subject: $tknType,
            audience: null,
        );
        $validated = $jwtValidator->validate($token, $this->jwtSigner);
        return [
            'validated' => $validated,
            'user' => $validated ? User::create($token->claims()->get('user')) : null,
        ];
    }

    protected function issueJwt(string $subject, array $claims, array $dayHourMinute = [0, 1]): string
    {
        $jwtIssuer = new JwtIssuer(
            issuer: $this->issuer,
            subject: $subject,
            audiences: [],
            claims: $claims,
        );
        $jwtIssuer->setExpires(...$dayHourMinute);
        $token = $jwtIssuer->issue($this->jwtSigner);
        return $token->toString();
    }
}
