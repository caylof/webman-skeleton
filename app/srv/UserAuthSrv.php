<?php

namespace app\srv;

use app\auth\UserAuth;
use app\exception\BusinessException;
use app\model\User;
use app\shared\helper\SignHelper;

class UserAuthSrv
{
    const SignUpScene = 1;
    const LoginScene = 2;

    protected SignHelper $signHelper;
    protected UserAuth $userAuth;

    public function __construct()
    {
        $this->signHelper = new SignHelper(config('services.sign.captcha_secret'), 120);
        $this->userAuth = new UserAuth();
    }

    public function signup(array $dto): array
    {
        if (! $this->signHelper->check($dto['captcha_key'], $dto['captcha_code'], self::SignUpScene)) {
            throw new BusinessException(trans('CaptchaVerifyFailed'));
        }
        $existUser = User::findByUsername($dto['username']);
        if ($existUser) {
            throw new BusinessException(trans('UserExistsCantRepeat'));
        }

        $user = new User();
        $user->username = $dto['username'];
        $user->password = $dto['password'];
        $user->nickname = $dto['nickname'] ?? null;
        $user->save();

        return $this->userAuth->publish(['id' => $user->id]);
    }

    public function login(array $dto): array
    {
        if (! $this->signHelper->check($dto['captcha_key'], $dto['captcha_code'], self::LoginScene)) {
            throw new BusinessException(trans('CaptchaVerifyFailed'));
        }
        $user = User::findByUsername($dto['username']);
        if (empty($user)) {
            throw new BusinessException(trans('UserNotExists'));
        }
        if (! $user->verifyPassword($dto['password'])) {
            throw new BusinessException(trans('PasswordError'));
        }

        return $this->userAuth->publish(['id' => $user->id]);;
    }
}
