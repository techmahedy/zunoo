<?php

namespace App\Core;

class Rule
{
    /**
     * validate.
     *
     * @access	public
     * @param	mixed	$input	
     * @param	mixed	$rules	
     * @return	mixed
     */
    public function validate($rules): mixed
    {
        $errors = [];
        $input = request()->getBody();

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

                    if ($rule == "unique" && $this->isRecordUnique($input, $fieldName, $ruleValue)) :
                        $errors[$fieldName]['unique'] = $this->_removeUnderscore(ucfirst($fieldName)) . " field is already exists.";
                    endif;

                endforeach;
            endforeach;
        endif;

        if ($errors) {
            session()->flash('errors', $errors);
            return redirect()->back();
        }
        return $errors;
    }

    /**
     * isEmptyFieldRequired.
     *
     * @param	mixed	$input    	
     * @param	mixed	$fieldName	
     * @return	mixed
     */
    public function isEmptyFieldRequired($input, $fieldName): mixed
    {
        return $input[$fieldName] == "" || empty($input[$fieldName]);
    }

    /**
     * isLessThanMin.
     *
     * @param	mixed	$input    	
     * @param	mixed	$fieldName	
     * @param	mixed	$value    	
     * @return	mixed
     */
    public function isLessThanMin($input, $fieldName, $value): mixed
    {
        return strlen($input[$fieldName]) < $value;
    }

    /**
     * isMoreThanMax.
     *
     * @param	mixed	$input    	
     * @param	mixed	$fieldName	
     * @param	mixed	$value    	
     * @return	mixed
     */
    public function isMoreThanMax($input, $fieldName, $value): mixed
    {
        return strlen($input[$fieldName]) > $value;
    }

    /**
     * isRecordUnique.
     *
     * @param	mixed	$input    	
     * @param	mixed	$fieldName	
     * @param	mixed	$value    	
     * @return	mixed
     */
    public function isRecordUnique($input, $fieldName, $value): mixed
    {
        $modelPath = <<<TEXT
        App\Models\
        TEXT;
        $model = $modelPath . ucfirst($value);
        return $model::where($fieldName, $input[$fieldName])->exists();
    }

    /**
     * isEmailValid.
     *
     * @param	mixed	$input    	
     * @param	mixed	$fieldName	
     * @return	boolean
     */
    public function isEmailValid($input, $fieldName): bool
    {
        $email = $input[$fieldName];

        if (!empty($email) || $email != "") :
            return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) ? FALSE : TRUE;
        else :
            return TRUE;
        endif;
    }


    /**
     * _removeUnderscore.
     *
     * @param	mixed	$string	
     * @return	mixed
     */
    public function _removeUnderscore($string): mixed
    {
        return str_replace("_", " ", $string);
    }

    /**
     * _removeRuleSuffix.
     *
     * @param	mixed	$string	
     * @return	mixed
     */
    public function _removeRuleSuffix($string): mixed
    {
        $arr = explode(":", $string);

        return $arr[0];
    }

    /**
     * _getRuleSuffix.
     *
     * @param	mixed	$string	
     * @return	mixed
     */
    public function _getRuleSuffix($string): mixed
    {
        $arr = explode(":", $string);

        return isset($arr[1]) ? $arr[1] : null;
    }
}
