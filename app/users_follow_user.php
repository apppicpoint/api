<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class users_follow_user extends Model
{
    protected  $fillable = ['follower_user_id','followed_user_id'];
    protected $table = 'users_follow_users';
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
