<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class WordsCountRule implements ValidationRule
{
    protected $count;

    public function __construct($count = 3)
    {
        $this->count = $count;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (strip_tags(str_word_count($value)) < $this->count) {
            $fail('This field accepts at least ' . $this->count . ' words.');
        }
    }
}
