<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tags extends Model
{
    protected  $fillable = ['name'];
    protected $table = 'tags';
    public $timestamps = true;

    public function publications()
    {
        return $this->belongsToMany('App\publication');
    }

    public function spots()
    {
        return $this->belongsToMany('App\spot');
    }
}
