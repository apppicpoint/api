<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class users_like_publication extends Model
{
    protected  $fillable = ['user_id','publication_id'];
    protected $table = 'users_like_publications';
    public $timestamps = true;

    public function publication()
    {
        return $this->belongsTo('App\publication');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
