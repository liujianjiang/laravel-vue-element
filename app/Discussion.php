<?php

namespace App;

use App\Scopes\StatusScope;
use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    protected $dates = ['delete_at'];

    protected $fillable = ['user_id', 'last_user_id', 'title', 'content', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new StatusScope());
    }
}
