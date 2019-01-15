<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class spot extends Model
{
    protected  $fillable = ['name','description','latitude','longitude','user_id'];
    protected $table = 'spots';
    public $timestamps = true;


    public function publications()
    {
        return $this->hasMany('App\publication');
    }

    public function comments()
    {
        return $this->hasMany('App\comment');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function tags()
    {
        return $this->belongsToMany('App\tag');
    }
}
