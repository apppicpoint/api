<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    protected  $fillable = ['text','user_id','comment_id','spot_id'];
    protected $table = 'comments';
    public $timestamps = true;

    public function spot()
    {
        return $this->belongsTo('App\spot');
    }

    public function comment()
    {
        return $this->belongsTo('App\comment');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comments()
    {
        return $this->hasMany('App\comment');
    }
}
