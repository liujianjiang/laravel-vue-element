<?php

namespace App;


use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Zizaco\Entrust\Traits\EntrustUserTrait;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{

    use HasApiTokens,Notifiable,EntrustUserTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function post(){
        return $this->hasMany(Posts::class);
    }

    public function discussions()
    {
        return $this->hasMany(Discussion::class)->orderBy('created_at', 'desc');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderby('create_at', 'desc');
    }
}
