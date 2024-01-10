<?php

namespace app\srv;

use app\exception\BusinessException;
use app\model\User;

class UserAuthSrv
{
    public function signup(array $dto): User
    {
        $existUser = User::findByUsername($dto['username']);
        if ($existUser) {
            throw new BusinessException(trans('UserExistsCantRepeat'));
        }
        $user = new User();
        $user->fill($dto);
        $user->save();
        return $user;
    }

    public function login(array $dto): User
    {
        $user = User::findByUsername($dto['username']);
        if (empty($user)) {
            throw new BusinessException(trans('UserNotExists'));
        }
        if (! $user->verifyPassword($dto['password'])) {
            throw new BusinessException(trans('PasswordError'));
        }
        return $user;
    }
}
