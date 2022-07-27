<?php

namespace App\Models;

use App\Traits\Slugger;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Slugger;
    protected $fillable = [
        'title', 'slug', 'image', 'category_id', 'content', 'excerpt', 'user_id'
    ];

    public function category() {
        return $this->belongsTo('App/Models/Category');
    }

    public function tags(){
        return $this->belongsToMany('App\Models\Tag');
    }

    public function user(){
        return $this->belongsTo('App/Models/User');
    }

    //per passare come link lo slug invece che l'id (lo slug deve essere univoco)
    public function getRouteKeyName()
    {
        return 'slug';
    }
}

