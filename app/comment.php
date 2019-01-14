<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    protected  $fillable = ['text','user_id','comment_id','spot_id'];
    protected $table = 'comments';
    public $timestamps = true;
}
