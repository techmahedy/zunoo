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

    /**
     * @var		array	$errors
     */
    public array $errors = [];

    /**
     * Requested data and saving it for old form value.
     *
     * @access	public
     * @param	mixed	$data	
     * @return	void
     */
    public function old($data): void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules(): array;

    /**
     * validated.
     *
     * @access	public
     * @return	void
     */
    public function validated(): bool
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

    /**
     * generateError.
     *
     * @access	public
     * @param	string	$attribute	
     * @param	string	$errorType	
     * @param	array 	$params   	Default: []
     * @return	void
     */
    public function generateError(string $attribute, string $errorType, $params = []): void
    {
        $message = $this->errorMessages()[$errorType] ?: '';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }

        $this->errors[$attribute][] = $message;
    }

    /**
     * errorMessages.
     *
     * @access	public
     * @return	array
     */
    public function errorMessages(): array
    {
        return [
            self::required => 'This field is required',
            self::email => 'This field must be valid email',
            self::min => 'Min length of this field must be {min}',
            self::max => 'Min length of this field must be {max}',
            self::match => 'This field must be the same as {match}'
        ];
    }

    /**
     * hasError.
     *
     * @access	public
     * @param	mixed	$attribute	
     * @return	mixed
     */
    public function hasError($attribute): mixed
    {
        return $this->errors[$attribute] ?? false;
    }

    /**
     * getErrorMessage.
     *
     * @access	public
     * @param	mixed	$attribute	
     * @return	mixed
     */
    public function getErrorMessage($attribute): mixed
    {
        return $this->errors[$attribute][0] ?? false;
    }
}
