<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];


    protected $fillable = [
        'tag', 'title', 'meta_description'
    ];

    public function articles()
    {
        return $this->morphedByMany('App\Article', 'article_tag');
    }

}
