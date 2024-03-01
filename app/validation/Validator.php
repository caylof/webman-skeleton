<?php

namespace app\validation;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;

class Validator extends \Illuminate\Validation\Validator
{

    protected array $trimExceptFields = ['password'];

    public function __construct(array $data, array $rules, array $messages = [], array $customAttributes = [])
    {
        $translator = new Translator(
            new FileLoader(new Filesystem(), base_path() . '/resource/translations'),
            config('translation.locale', 'zh_CN')
        );
        $this->covertEmptyStringToNull($data);
        parent::__construct($translator, $data, $rules, $messages, $customAttributes);
    }

    public function covertEmptyStringToNull(array &$arr)
    {
        foreach ($arr as $key => &$value) {
            if (is_array($value)) {
                $this->covertEmptyStringToNull($value);
            } else {
                if (is_string($value) && !in_array($key, $this->trimExceptFields)) {
                    $value = preg_replace('~^[\s﻿]+|[\s﻿]+$~u', '', $value) ?? trim($value);
                }
                if (empty($value)) {
                    $value = null;
                }
            }
        }
    }
}
