<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustPermission;
class Permission extends EntrustPermission
{
    protected $table = 'permission';

    protected $fillable = ['fid', 'icon', 'name', 'display_name', 'description', 'is_menu', 'sort'];

    public function roles()
    {
        return $this->belongsToMany('App\Role', 'permission_role', 'permission_id', 'role_id');
    }
}
