<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    protected  $fillable = ['name'];
    protected $table = 'roles';
    public $timestamps = true;
}
