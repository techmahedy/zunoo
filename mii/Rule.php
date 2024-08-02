<?php

namespace Mii;

class Rule
{
    /**
     * Validate the input data against the given rules.
     *
     * @access public
     * @param array $rules Associative array of field names and their validation rules.
     * @return array|null Validation errors or null if no errors.
     */
    public function validate(array $rules): ?array
    {
        $errors = [];
        $input = request()->all();

        if (is_array($input)) {
            foreach ($rules as $fieldName => $value) {
                $fieldRules = explode("|", $value);

                foreach ($fieldRules as $rule) {
                    $ruleValue = $this->_getRuleSuffix($rule);
                    $rule = $this->_removeRuleSuffix($rule);

                    switch ($rule) {
                        case 'required':
                            if ($this->isEmptyFieldRequired($input, $fieldName)) {
                                $errors[$fieldName]['required'] = $this->_removeUnderscore(ucfirst($fieldName)) . " field is required.";
                            }
                            break;

                        case 'email':
                            if (!$this->isEmailValid($input, $fieldName)) {
                                $errors[$fieldName]['email'] = $this->_removeUnderscore(ucfirst($fieldName)) . " field is invalid.";
                            }
                            break;

                        case 'min':
                            if ($this->isLessThanMin($input, $fieldName, $ruleValue)) {
                                $errors[$fieldName]['min'] = $this->_removeUnderscore(ucfirst($fieldName)) . " field must be at least " . $ruleValue . " characters.";
                            }
                            break;

                        case 'max':
                            if ($this->isMoreThanMax($input, $fieldName, $ruleValue)) {
                                $errors[$fieldName]['max'] = $this->_removeUnderscore(ucfirst($fieldName)) . " field must not exceed " . $ruleValue . " characters.";
                            }
                            break;

                        case 'unique':
                            if (!$this->isRecordUnique($input, $fieldName, $ruleValue)) {
                                $errors[$fieldName]['unique'] = $this->_removeUnderscore(ucfirst($fieldName)) . " field already exists.";
                            }
                            break;
                    }
                }
            }
        }

        if (!empty($errors)) {
            session()->flash('errors', $errors);
            foreach ($errors as $key => $error) {
                session()->flash($key, $error);
            }
            return redirect()->back()->withInput()->withErrors($errors);
        }

        return null;
    }

    /**
     * Check if a required field is empty.
     *
     * @param array $input The input data.
     * @param string $fieldName The field name.
     * @return bool
     */
    public function isEmptyFieldRequired(array $input, string $fieldName): bool
    {
        return empty($input[$fieldName]);
    }

    /**
     * Check if a field value is less than the minimum length.
     *
     * @param array $input The input data.
     * @param string $fieldName The field name.
     * @param int $value The minimum length.
     * @return bool
     */
    public function isLessThanMin(array $input, string $fieldName, int $value): bool
    {
        return strlen($input[$fieldName]) < $value;
    }

    /**
     * Check if a field value exceeds the maximum length.
     *
     * @param array $input The input data.
     * @param string $fieldName The field name.
     * @param int $value The maximum length.
     * @return bool
     */
    public function isMoreThanMax(array $input, string $fieldName, int $value): bool
    {
        return strlen($input[$fieldName]) > $value;
    }

    /**
     * Check if a record is unique.
     *
     * @param array $input The input data.
     * @param string $fieldName The field name.
     * @param string $value The model name.
     * @return bool
     */
    public function isRecordUnique(array $input, string $fieldName, string $value): bool
    {
        $modelPath = 'App\Models\\';
        $model = $modelPath . ucfirst($value);
        return !$model::where($fieldName, $input[$fieldName])->exists();
    }

    /**
     * Validate if the email is valid.
     *
     * @param array $input The input data.
     * @param string $fieldName The field name.
     * @return bool
     */
    public function isEmailValid(array $input, string $fieldName): bool
    {
        $email = $input[$fieldName] ?? '';
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Remove underscores from a string and capitalize words.
     *
     * @param string $string The input string.
     * @return string
     */
    public function _removeUnderscore(string $string): string
    {
        return str_replace("_", " ", $string);
    }

    /**
     * Remove the suffix from a rule string.
     *
     * @param string $string The rule string.
     * @return string
     */
    public function _removeRuleSuffix(string $string): string
    {
        return explode(":", $string)[0];
    }

    /**
     * Get the suffix from a rule string.
     *
     * @param string $string The rule string.
     * @return string|null
     */
    public function _getRuleSuffix(string $string): ?string
    {
        $arr = explode(":", $string);
        return $arr[1] ?? null;
    }
}
