<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class users_like_publication extends Model
{
    protected  $fillable = ['user_id','publication_id'];
    protected $table = 'users_like_publications';
    public $timestamps = true;
}
