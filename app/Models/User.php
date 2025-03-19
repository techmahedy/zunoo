<?php

namespace App\Models;

use Zuno\Database\Eloquent\Model;

class User extends Model
{
    /**
     * Primary Key
     *
     * Specifies the column name that serves as the unique identifier for the table.
     * By default, this is set to 'id', but it can be customized if your table uses a different primary key.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Table Name
     *
     * Specifies the database table associated with this model.
     * By default, Eloquent assumes the table name is the plural form of the model name,
     * but you can explicitly define it here if it differs.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Creatable Attributes
     *
     * Specifies which attributes can be mass-assigned when creating or updating records.
     * This helps prevent mass assignment vulnerabilities by explicitly defining safe fields.
     * Only the attributes listed here can be set in bulk operations.
     *
     * @var array
     */
    protected $creatable = ['name', 'email', 'password', 'remember_token'];

    /**
     * Unexposable Attributes
     *
     * Specifies which attributes should be hidden when the model is converted to an array or JSON.
     * This is particularly useful for hiding sensitive information, such as passwords,
     * from being exposed in API responses or other outputs.
     *
     * @var array
     */
    protected $unexposable = ['password'];

    /**
     * Page Size
     *
     * Defines the number of records to be displayed per page when paginating results.
     * This property is useful for controlling the size of data chunks returned by queries.
     *
     * @var int
     */
    protected $pageSize = 10;

    /**
     * Indicates whether the model should maintain timestamps (`created_at` and `updated_at` fields.).
     *
     * @var bool
     */
    protected $timeStamps = true;
}
