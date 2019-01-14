<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class spot extends Model
{
    protected  $fillable = ['name','description','latitude','longitude','user_id'];
    protected $table = 'spots';
    public $timestamps = true;
}
