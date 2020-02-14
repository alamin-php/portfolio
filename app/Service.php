<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'category_id', 'tag_id', 'user_id', 'title', 'details', 'photo',
    ];
}
