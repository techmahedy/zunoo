<?php

namespace App\Core;

use Illuminate\Database\Eloquent\Model as BaseModel;

abstract class Model extends BaseModel
{
    public const required = 'required';
    public const email = 'email';
    public const min = 'min';
    public const max = 'max';
    public const match = 'match';

    public array $errors = [];

    public function old($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules(): array;

    public function validated()
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }
                if ($ruleName === self::required && !$value) {
                    $this->generateError($attribute, self::required);
                }
                if ($ruleName === self::email && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->generateError($attribute, self::email);
                }
                if ($ruleName === self::min && strlen($value) < $rule['min']) {
                    $this->generateError($attribute, self::max, $rule);
                }
                if ($ruleName === self::max && strlen($value) > $rule['max']) {
                    $this->generateError($attribute, self::max, $rule);
                }
                if ($ruleName === self::match && $value !== $this->{$rule['match']}) {
                    $this->generateError($attribute, self::match, $rule);
                }
            }
        }

        return empty($this->errors);
    }

    public function generateError(string $attribute, string $errorType, $params = [])
    {
        $message = $this->errorMessages()[$errorType] ?: '';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }

        $this->errors[$attribute][] = $message;
    }

    public function errorMessages()
    {
        return [
            self::required => 'This field is required',
            self::email => 'This field must be valid email',
            self::min => 'Min length of this field must be {min}',
            self::max => 'Min length of this field must be {max}',
            self::match => 'This field must be the same as {match}'
        ];
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getErrorMessage($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }
}
