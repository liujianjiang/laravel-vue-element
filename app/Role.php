<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    protected $table = 'roles';

    //protected $fillable = ['name', 'display_name', 'description', 'created_at'];
    protected $fillable = ['name', 'display_name', 'description'];

    public function adminUser()
    {
        return $this->belongsToMany('App\Admin', 'role_user', 'role_id', 'user_id');
        //return $this->belongsToMany('App\Admin');
        //return $this->belongsToMany('App\Admin')->using('App\AdminRole');
    }

    public function permissions()
    {
        return $this->belongsToMany('App\permission', 'permission_role', 'role_id', 'permission_id');
    }

    public function permissionsThis($role)
    {
        return $this->permissions()->where('role_id', $role)->get();
    }

}
