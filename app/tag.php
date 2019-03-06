<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tag extends Model
{
    protected  $fillable = ['name'];
    protected $table = 'tags';
    public $timestamps = true;
    use SoftDeletes;

    public function publications()
    {
        return $this->belongsToMany(publication::class, 'publications_tags', 'tag_id', 'publication_id')->withTimestamps();
    }

    public function spots()
    {
        return $this->belongsToMany(spot::class, 'spots_tags', 'tag_id', 'spot_id')->withTimestamps();
    }
}
