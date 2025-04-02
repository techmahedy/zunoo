<?php

namespace App\Models;

use Zuno\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tag';

    public function posts()
    {
        return $this->manyToMany(
            Post::class,  // Related model
            'tag_id',   // Foreign key for tags in pivot table
            'post_id',  // Foreign key for posts in pivot table
            'post_tag'  // Pivot table name
        );
    }
}
