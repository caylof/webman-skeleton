<?php

namespace app\controller;

use app\auth\UserAuth;
use app\form\UserLoginForm;
use app\form\UserSignupForm;
use app\model\User;
use app\srv\UserAuthSrv;
use support\Request;
use support\Response;

class AuthController
{
    public function signup(Request $request, UserSignupForm $userSignupForm, UserAuthSrv $userAuthSrv, UserAuth $userAuth): Response
    {
        $dto = $userSignupForm->validate($request->post());
        $user = $userAuthSrv->signup($dto);
        $result = $userAuth->publish(['id' => $user->id]);
        return json($result);
    }

    public function login(Request $request, UserLoginForm $userSignInForm, UserAuthSrv $userAuthSrv, UserAuth $userAuth): Response
    {
        $dto = $userSignInForm->validate($request->post());
        $user = $userAuthSrv->login($dto);
        $result = $userAuth->publish(['id' => $user->id]);
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
