<?php

namespace App\Models;

use App\Traits\Slugger;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Slugger;

    public $timestamps = false;

    public function posts() {
        return $this->hasMany('App/Models/Post');
    }

    //per passare come link lo slug invece che l'id (lo slug deve essere univoco)
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
