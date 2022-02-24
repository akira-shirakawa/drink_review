<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    public function tags()
    {
        return $this->belongsToMany('App\Category');
    }
    public function likes()
    {
        return $this->belongsToMany('App\User');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
}
