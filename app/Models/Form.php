<?php

namespace App\Models;

class Form extends Model
{
    protected $table = 'forms';

    protected $hidden = ['acl'];

    public function answer()
    {
        return $this->hasOne(FormAnswer::class);
    }

    public function answers()
    {
        return $this->hasMany(FormAnswer::class);
    }
}
