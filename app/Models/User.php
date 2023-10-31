<?php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    public string $name;
    public string $email;
    public string $password;
    public string $confirm_password;

    protected $fillable = [
        'name',
        'email',
        'password',
        'confirm_password'
    ];

    public function rules(): array
    {
        return [
            'name' => [self::REQUIRED],
            'email' => [self::REQUIRED, self::EMAIL],
            'password' => [self::REQUIRED, [self::MIN, 'min' => '4']],
            'confirm_password' => [self::REQUIRED, [self::MATCH, 'match' => 'password']],
        ];
    }
}
