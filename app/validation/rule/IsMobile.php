<?php

namespace app\validation\rule;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IsMobile implements ValidationRule
{

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (preg_match('/^1[0-9]{10}$/', $value) !== 1) {
            $fail('validation.is_mobile')->translate();
        }
    }
}