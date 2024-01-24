<?php

namespace app\controller;

use app\form\UserLoginForm;
use app\form\UserSignupForm;
use app\model\User;
use app\srv\UserAuthSrv;
use support\Request;
use support\Response;

class AuthController
{
    public function signup(Request $request, UserSignupForm $userSignupForm, UserAuthSrv $userAuthSrv): Response
    {
        $dto = $userSignupForm->validate($request->post());
        $result = $userAuthSrv->signup($dto);
        return json($result);
    }

    public function login(Request $request, UserLoginForm $userSignInForm, UserAuthSrv $userAuthSrv): Response
    {
        $dto = $userSignInForm->validate($request->post());
        $result = $userAuthSrv->login($dto);
        return json($result);
    }

    public function meInfo(Request $request): Response
    {
        /* @var array $authUser */
        $authUser = $request->authUser;
        $user = User::find($authUser['id']);
        return json($user->toArray());
    }
}
