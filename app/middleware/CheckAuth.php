<?php

namespace app\middleware;

use app\exception\AuthenticationException;
use app\auth\Auth;
use Webman\Http\Request;
use Webman\Http\Response;
use Webman\MiddlewareInterface;

class CheckAuth implements MiddlewareInterface
{
    protected Auth $authSrv;

    public function __construct()
    {
        $this->authSrv = new Auth();
    }

    public function process(Request $request, callable $handler): Response
    {
        $jwtStr = $this->getBearerToken($request);
        if (empty($jwtStr)) {
            throw new AuthenticationException;
        }

        ['validated' => $validated, 'user' => $user] = $this->authSrv->verify(Auth::TKN_TYPE_ACCESS, $jwtStr);
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