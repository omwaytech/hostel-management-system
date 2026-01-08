<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemBlog extends Model
{
    protected $fillable = [
        'blog_title',
        'blog_image',
        'blog_badge',
        'blog_time_to_read',
        'blog_description',
        'blog_author_name',
        'blog_author_image',
        'slug',

        'page_title',
        'meta_tags',
        'meta_description',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
