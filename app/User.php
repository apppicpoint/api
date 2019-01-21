<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class user extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','nickName', 'biography', 'telephone', 'photo', 'banned'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $table = 'users';
    
    public $timestamps = true;

    public function role()
    {
        return $this->belongsTo('App\role');
    }

    public function reports()
    {
        return $this->hasMany('App\report');
    }

    public function publications()
    {
        return $this->hasMany('App\publication');
    }

    public function comments()
    {
        return $this->hasMany('App\comment');
    }

    public function spots()
    {
        return $this->hasMany('App\spot');
    }

    public function publicationslike()
    {
        return $this->belongsToMany('App\publication');
    }

    public function spotsrate()
    {
        return $this->belongsToMany('App\spot');
    }

    public function users()
    {
        return $this->belongsToMany('App\user');
    }
}
