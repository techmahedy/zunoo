<?php

namespace App\Models;

use Zuno\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment';

    public function user()
    {
        return $this->oneToOne(
            User::class,
            'id',
            'user_id'
        );
    }

    public function post()
    {
        return $this->oneToOne(
            Post::class,
            'id',
            'post_id'
        );
    }
}
