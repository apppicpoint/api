<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class report extends Model
{
    protected  $fillable = ['text','type','object_id','user_id'];
    protected $table = 'reports';
    public $timestamps = true;
}
