<?php

namespace app\middleware;

use app\auth\Base;
use app\exception\AuthenticationException;
use app\auth\UserAuth;
use Webman\Http\Request;
use Webman\Http\Response;
use Webman\MiddlewareInterface;

class CheckAuth implements MiddlewareInterface
{
    public function __construct(protected Base $authSrv) {}

    public function process(Request $request, callable $handler): Response
    {
        $jwtStr = $this->getBearerToken($request);
        if (empty($jwtStr)) {
            throw new AuthenticationException;
        }

        ['validated' => $validated, 'user' => $user] = $this->authSrv->verify(UserAuth::TKN_TYPE_ACCESS, $jwtStr);
        if (! $validated) {
            throw new AuthenticationException;
        }

        $request->authUser = $user;
        return $handler($request);
    }

    private function getBearerToken(Request $request): ?string
    {
        $header = $request->header('authorization', '');
        $position = strrpos($header, 'Bearer ');
        if (false === $position) {
            return null;
        }
        return substr($header, $position + 7);
    }
}