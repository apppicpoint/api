<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class publications_tag extends Model
{
    protected  $fillable = ['publication_id','tag_id'];
    protected $table = 'publications_tags';
    public $timestamps = true;
}
