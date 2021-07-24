<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Filter implements Rule
{
    protected $words = [];
    protected $attribute;
    protected $filtered;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($words)
    {
        $this->words = $words;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        foreach ($this->words as $word) {
            if (stripos($value, $word) !== false) {
                $this->attribute = $attribute;
                $this->filtered = $word;
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'you cannot use [ ' . $this->filtered .' ] word in [ ' . $this->attribute . ' ] input.';
    }
}
