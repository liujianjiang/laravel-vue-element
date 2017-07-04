<?php

namespace App\Repositories;

use App\Role;

class RoleRepository
{
    use BaseRepository;

    protected $model;

    /**
     * RoleRepository constructor.
     * @param Role $role
     */
    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    /**
     * @param $id
     * @return mixed
     * author Fox
     */
    public function getPermissionsById($id)
    {
        return $this->model->with('permissions')->where(['id' => $id])->first();
    }

    /**
     * @param $id
     * @param array $perms
     * @return bool
     * author Fox
     */
    public function savePermissions($id , $perms = [])
    {

        $role =  $this->model->findOrFail($id);

        $role->permissions()->sync($perms);

        return true;

    }


}
