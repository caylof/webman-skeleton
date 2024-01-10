<?php

namespace app\validation;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Validator;

abstract class Form
{
    protected Validator $validator;
    protected array $rules = [];
    protected array $messages = [];
    protected array $attributes = [];

    public function __construct()
    {
        $translator = new Translator(
            new FileLoader(new Filesystem(), base_path() . '/resource/translations'),
            config('translation.locale', 'zh_CN')
        );
        $this->validator = new Validator(
            translator: $translator,
            data: [],
            rules: $this->rules,
            messages: $this->messages,
            attributes: $this->attributes
        );
    }

    public function validate(array $data): array
    {
        $this->validator->setData($data);
        return $this->validator->validate();
    }
}
