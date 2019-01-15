<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class publication extends Model
{
    protected  $fillable = ['description','media','user_id','spot_id'];
    protected $table = 'publications';
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function spot()
    {
        return $this->belongsTo('App\spot');
    }

    public function tags()
    {
        return $this->belongsToMany('App\tag');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
