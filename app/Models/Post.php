<?php

namespace App\Models;

use Zuno\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'post';

    protected $creatable = ['title', 'user_id'];

    public function user()
    {
        return $this->oneToOne(
            User::class,
            'id',
            'user_id'
        );
    }

    public function comments()
    {
        return $this->oneToMany(
            Comment::class,
            'post_id',
            'id'
        );
    }

    public function tags()
    {
        return $this->manyToMany(
            Tag::class,    // Related model
            'post_id',   // Foreign key for posts in pivot table (post_tag.post_id)
            'tag_id',    // Foreign key for tags in pivot table (post_tag.tag_id)
            'post_tag'   // Pivot table name
        );
    }
}
