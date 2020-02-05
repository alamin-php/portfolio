<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'category_id','tag_id','user_id','title','details','photo',
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function tag()
    {
        return $this->belongsTo('App\Tag');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
