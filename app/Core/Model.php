<?php

namespace App\Core;

use Illuminate\Database\Eloquent\Model as BaseModel;

abstract class Model extends BaseModel
{
    public const REQUIRED = 'required';
    public const EMAIL = 'email';
    public const MIN = 'min';
    public const MAX = 'max';
    public const MATCH = 'match';

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
                if ($ruleName === self::REQUIRED && !$value) {
                    $this->generateError($attribute, self::REQUIRED);
                }
                if ($ruleName === self::EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->generateError($attribute, self::EMAIL);
                }
                if ($ruleName === self::MIN && strlen($value) < $rule['min']) {
                    $this->generateError($attribute, self::MIN, $rule);
                }
                if ($ruleName === self::MAX && strlen($value) > $rule['max']) {
                    $this->generateError($attribute, self::MAX, $rule);
                }
                if ($ruleName === self::MATCH && $value !== $this->{$rule['match']}) {
                    $this->generateError($attribute, self::MATCH, $rule);
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
            self::REQUIRED => 'This field is required',
            self::EMAIL => 'This field must be valid email',
            self::MIN => 'Min length of this field must be {min}',
            self::MAX => 'Min length of this field must be {max}',
            self::MATCH => 'This field must be the same as {match}'
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
