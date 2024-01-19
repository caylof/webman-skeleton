<?php

namespace app\controller;

use app\shared\helper\SignHelper;
use app\validation\Validator;
use support\Request;
use support\Response;
use Webman\Captcha\CaptchaBuilder;
use Webman\Captcha\PhraseBuilder;

class CaptchaController
{
    public function send(Request $request): Response
    {
        $vd = (new Validator($request->post(), [
            'scene' => ['required', 'integer', 'in:1,2'],
            'length' => ['integer', 'min:4', 'max:6'],
            'with' => ['integer', 'min:20', 'max:180'],
            'height' => ['integer', 'min:20', 'max:60'],
        ]))->validate();

        $phraseBuilder = new PhraseBuilder($vd['length'] ?? 4,'abcdefghjkmnprstuvwxy123456789ABCDEFGHJKMNPRSTUVWXY');
        $builder = new CaptchaBuilder(null, $phraseBuilder);
        $builder->build($vd['with'] ?? 120, $vd['height'] ?? 40);
        $code = $builder->getPhrase();
        $signHelper = new SignHelper(config('services.sign.captcha_secret'), 120);
        $key = $signHelper->generate(strtolower($code), $vd['scene']);
        $img = $builder->inline();

        return json(compact('key', 'img'));
    }
}
