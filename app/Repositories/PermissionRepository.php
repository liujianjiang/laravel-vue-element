<?php

namespace App\Repositories;

use App\Permission;


class PermissionRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }

    public function getTopPermissions()
    {
        return $this->model->where('fid', 0)->get();
    }

}
