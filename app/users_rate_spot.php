<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class users_rate_spot extends Model
{
    protected  $fillable = ['user_id','spot_id','rating'];
    protected $table = 'users_rate_spots';
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function spot()
    {
        return $this->belongsTo('App\spot');
    }
}
