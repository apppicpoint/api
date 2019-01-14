<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class publication extends Model
{
    protected  $fillable = ['description','media','user_id','spot_id'];
    protected $table = 'publications';
    public $timestamps = true;
}
