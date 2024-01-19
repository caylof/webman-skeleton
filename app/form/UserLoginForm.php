<?php

namespace app\form;

use app\validation\Form;

class UserLoginForm extends Form
{
    protected array $rules = [
        'username' => 'required|string|min:4|max:20',
        'password' => ['required','string','min:6'],
        'captcha_code' => ['required', 'string'],
        'captcha_key' => ['required', 'string'],
    ];

    protected array $attributes = [
        'username' => '用户名',
        'password' => '密码',
        'captcha_code' => '验证码',
    ];
}
