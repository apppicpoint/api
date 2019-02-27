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
        return $this->belongsToMany(spot::class, 'publications_tags', 'publication_id', 'tag_id')->withTimestamps();
    }

    public function spots()
    {
        return $this->belongsToMany(spot::class, 'spots_tags', 'spot_id', 'tag_id')->withTimestamps();
    }
}
