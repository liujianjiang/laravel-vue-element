<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RoleRequest;
use App\Permission;
use App\Repositories\RoleRepository;
use App\Role;
use App\Transformers\PermissionTransformer;
use App\Transformers\RoleTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends ApiController
{
    protected $role;
    protected $permission;

    public function __construct(RoleRepository $role, Permission $permission)
    {
        parent::__construct();
        $this->role = $role;
        $this->permission = $permission;
    }

    public function index(){
        $pageSize = intval(request('pagesize')) >0 ? request('pagesize') : 10;
        return $this->respondWithPaginator($this->role->page($pageSize), new RoleTransformer());
    }

    public function store(RoleRequest $request)
    {
        $this->role->store($request->all());

        return $this->noContent();
    }

    public function edit($id)
    {
        return $this->respondWithItem($this->role->getById($id), new RoleTransformer());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request,$id)
    {
        $this->role->update($id, $request->all());

        return $this->noContent();

    }

    public function destroy($id)
    {
        $str = explode(',',$id);
        foreach($str as $v){
            $this->role->destroy($v);
        }
    }

    public function getAllList()
    {
        return $this->respondWithCollection($this->role->all(), new RoleTransformer());
    }

    public function getAllPermissions()
    {

        $permissions = [];
        $topPermissions = $this->permission->where('fid', 0)->orderBy('sort', 'asc')->orderBy('id', 'asc')->get();

        foreach($topPermissions as $k => $v){
            $noToppermissions = $this->permission->where('fid', $v['id'])->get();
            $permissions[$k]['id'] = $v['id'];
            $permissions[$k]['label'] = $v['display_name'];
            foreach($noToppermissions as $k2 => $v2)
            {
                $permissions[$k]['children'][$k2]['id'] = $v2['id'];
                $permissions[$k]['children'][$k2]['label'] = $v2['display_name'];
            }
        }

        return $permissions;
    }

    /**
     * @param $id
     * @return mixed
     * author Fox
     */
    public function getPermissionsById($id)
    {
        return $this->role->getPermissionsById($id);
    }

    /**
     * @param $id
     * @param Request $request
     * author Fox
     */
    public function savaPermission($id, Request $request)
    {
        $this->role->savePermissions($id, $request->all());
        $this->noContent();
    }
}
