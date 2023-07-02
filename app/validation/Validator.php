<?php

namespace app\validation;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;

class Validator extends \Illuminate\Validation\Validator
{

    public function __construct(array $data, array $rules, array $messages = [], array $customAttributes = [])
    {
        $translator = new Translator(
            new FileLoader(new Filesystem(), base_path() . '/resource/translations'),
            config('translation.locale', 'zh_CN')
        );
        parent::__construct($translator, $data, $rules, $messages, $customAttributes);
    }
}
