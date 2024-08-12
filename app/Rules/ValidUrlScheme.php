<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidUrlScheme implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }
    public function rules()
    {
        return [
            'web_url' => [
                'required',
                'url',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^https?:\/\//', $value)) {
                        $fail('The ' . $attribute . ' must start with http:// or https://.');
                    }
                },
            ],
            // other rules...
        ];
    }
}
