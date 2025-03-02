<?php

namespace App\Models;

use Zuno\Model;
use Zuno\Auth\Security\Hash;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Model
{
    /**
     * Mass Assignable Attributes
     *
     * Specify which attributes should be mass-assignable. This helps protect against mass assignment
     * vulnerabilities. Define the attributes you want to be mass-assignable in this property.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'username', 'email', 'password'];

    /**
     * Hidden Attributes
     *
     * Specify which attributes should be hidden from arrays. For example, you might want to hide sensitive
     * information such as passwords from the model's array or JSON representation.
     *
     * @var array
     */
    protected $hidden = ['password'];

    // Set to user password attribute hashed when create a new user using password
    protected function password(): Attribute
    {
        return Attribute::make(set: fn($value) => Hash::make($value));
    }
}
