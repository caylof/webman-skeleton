<?php

namespace app\controller;

use app\auth\Auth;
use app\auth\User;
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
        $result = $auth->publish(User::create([
            'id' => 'u1',
            'name' => 'cctv'
        ]));
        return json($result);
    }

    public function meInfo(Request $request): Response
    {
        /* @var $user \app\auth\User */
        $user = $request->authUser;
        return json($user);
    }

}
