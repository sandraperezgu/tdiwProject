<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const CLOSED_POST = 0;
    const OPEN_POST = 1;
    const SELECTED_ANSWER = 2;
    public function tags(){
        return $this->belongsToMany(Tag::class)->using(TagPost::class);
    }
    public function votes(){
        return $this->belongsToMany("App\User")->using("App\Post_score");
    }
    protected $table = 'post';
}
