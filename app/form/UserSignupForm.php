<?php

namespace app\form;

use app\validation\Form;

class UserSignupForm extends Form
{
    protected array $rules = [
        'username' => 'required|string|min:4|max:20',
        'password' => 'required|string|min:6',
        'nickname' =>'nullable|string|min:4|max:20',
    ];

    protected array $attributes = [
        'username' => '用户名',
        'password' => '密码',
        'nickname' => '昵称',
    ];
}
