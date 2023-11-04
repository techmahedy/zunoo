<?php

namespace App\Core;

class Rule
{
    public function validate($input, $rules)
    {
        $errors = [];

        if (is_array($input)) :
            foreach ($rules as $fieldName => $value) :
                $fieldRules = explode("|", $value);

                foreach ($fieldRules as $rule) :

                    $ruleValue = $this->_getRuleSuffix($rule);
                    $rule = $this->_removeRuleSuffix($rule);

                    if ($rule == "required" && $this->isEmptyFieldRequired($input, $fieldName)) :
                        $errors[$fieldName]['required'] = $this->_removeUnderscore(ucfirst($fieldName)) . " field is required.";
                    endif;

                    if ($rule == "email" && !$this->isEmailValid($input, $fieldName)) :
                        $errors[$fieldName]['email'] = $this->_removeUnderscore(ucfirst($fieldName)) . " field is invalid.";
                    endif;

                    if ($rule == "min" && $this->isLessThanMin($input, $fieldName, $ruleValue)) :
                        $errors[$fieldName]['max'] = $this->_removeUnderscore(ucfirst($fieldName)) . " field is less than " . $ruleValue . " characters of the minimum length.";
                    endif;

                    if ($rule == "max" && $this->isMoreThanMax($input, $fieldName, $ruleValue)) :
                        $errors[$fieldName]['max'] = $this->_removeUnderscore(ucfirst($fieldName)) . " field is more than " . $ruleValue . " characters of the maximum length.";
                    endif;

                    if ($rule == "unique" && !$this->isRecordUnique($input, $fieldName, $ruleValue)) :
                        $errors[$fieldName]['unique'] = $this->_removeUnderscore(ucfirst($fieldName)) . " field is already exists.";
                    endif;

                endforeach;
            endforeach;
        endif;

        return $errors;
    }

    public function isEmptyFieldRequired($input, $fieldName)
    {
        return $input[$fieldName] == "" || empty($input[$fieldName]);
    }

    public function isLessThanMin($input, $fieldName, $value)
    {
        return strlen($input[$fieldName]) < $value;
    }

    public function isMoreThanMax($input, $fieldName, $value)
    {
        return strlen($input[$fieldName]) > $value;
    }

    public function isRecordUnique($input, $fieldName, $value)
    {
        $modelPath = <<<TEXT
        App\Models\
        TEXT;
        $model = $modelPath . ucfirst($value);
        return $model::where($fieldName, $input[$fieldName])->exists();
    }

    public function isEmailValid($input, $fieldName)
    {
        $email = $input[$fieldName];

        if (!empty($email) || $email != "") :
            return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) ? FALSE : TRUE;
        else :
            return TRUE;
        endif;
    }


    public function _removeUnderscore($string)
    {
        return str_replace("_", " ", $string);
    }

    public function _removeRuleSuffix($string)
    {
        $arr = explode(":", $string);

        return $arr[0];
    }

    public function _getRuleSuffix($string)
    {
        $arr = explode(":", $string);

        return isset($arr[1]) ? $arr[1] : null;
    }
}
