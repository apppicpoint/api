<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class publications_tag extends Model
{
    protected  $fillable = ['publication_id','tag_id'];
    protected $table = 'publications_tags';
    public $timestamps = true;

    public function publication()
    {
        return $this->belongsTo('App\publication');
    }

    public function tag()
    {
        return $this->belongsTo('App\tag');
    }
}
