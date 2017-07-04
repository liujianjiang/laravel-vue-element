<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Navigation extends Model
{
    protected $table = 'navigation';

    protected $fillable = ['name', 'url', 'sort' ,'published_at'];

}
