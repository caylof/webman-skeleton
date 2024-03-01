<?php

namespace app\validation;

abstract class Form
{
    protected Validator $validator;
    protected array $rules = [];
    protected array $messages = [];
    protected array $attributes = [];

    public function __construct()
    {
        $this->validator = new Validator(
            data: [],
            rules: [...$this->rules, ...$this->rules()],
            messages: $this->messages,
            customAttributes: $this->attributes
        );
    }

    public function validate(array $data): array
    {
        $this->validator->covertEmptyStringToNull($data);
        $this->validator->setData($data);
        return $this->validator->validate();
    }

    protected function rules(): array
    {
        return [];
    }
}
