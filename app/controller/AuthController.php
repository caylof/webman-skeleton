<?php

namespace app\controller;

use app\auth\Auth;
use app\validation\rule\IsMobile;
use app\validation\Validator;
use support\Request;
use support\Response;

class AuthController
{
    public function login(Request $request): Response
    {
        $v = new Validator($request->post(), [
            'mobile' => ['required', 'string', new IsMobile()],
            'code' => ['required', 'string'],
        ]);
        $vd = $v->validate();

        $auth = new Auth();
        $result = $auth->publish([
            'id' => 'u1',
            'name' => 'cctv'
        ]);
        return json($result);
    }

    public function meInfo(Request $request): Response
    {
        /* @var array $user */
        $user = $request->authUser;
        return json($user);
    }

}
