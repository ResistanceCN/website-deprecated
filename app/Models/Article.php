<?php

namespace App\Models;

class Article extends Model
{
    protected $table = 'articles';

    protected $dates = ['created_at', 'published_at'];

    public function content()
    {
        return $this->hasOne(ArticleContent::class);
    }
}
