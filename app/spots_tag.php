<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class spots_tag extends Model
{
    protected  $fillable = ['spot_id','tag_id'];
    protected $table = 'spots_tags';
    public $timestamps = true;
}
