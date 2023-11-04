<?php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    // /**
    //  * Use any features of Laravel.
    //  */


    // /**
    //  * rules.
    //  *
    //  * Use this methid for form valiation. If this model no need to validate, then just return an empty array
    //  * @return	array
    //  */
    // public function rules(): array
    // {
    //     return [];
    // }
    public string $name;
    public string $email;
    public string $password;
    public string $confirm_password;

    public function rules(): array
    {
        return [
            'name' => [self::required],
            'email' => [self::required, self::email],
            'password' => [self::required, [self::min, 'min' => '4']],
            'confirm_password' => [self::required, [self::match, 'match' => 'password']]
        ];
    }
}
