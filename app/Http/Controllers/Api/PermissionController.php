<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\PermissionRequest;
use App\Repositories\PermissionRepository;
use App\Transformers\PermissionTransformer;

/**
 * Class PermissionController
 * @package App\Http\Controllers\Api
 * anthor Fox
 */

class PermissionController extends ApiController
{
    /**
     * @var PermissionRepository
     */
    protected $permission;

    /**
     * PermissionController constructor.
     * @param PermissionRepository $permission
     */
    public function __construct(PermissionRepository $permission)
    {
        parent::__construct();
        $this->permission = $permission;
    }

    /**
     * @return mixed
     * author Fox
     */
    public function index()
    {
        $pageSize = intval(request('pagesize')) >0 ? request('pagesize') : 10;
        return $this->respondWithPaginator($this->permission->page($pageSize), new PermissionTransformer());
    }

    /**
     * @return mixed
     * author Fox
     */
    public function topPermissions()
    {
        return $this->respondWithCollection($this->permission->getTopPermissions(), new PermissionTransformer());
    }

    /**
     * @param $id
     * @return mixed
     * author Fox
     */
    public function edit($id)
    {
        return $this->respondWithItem($this->permission->getById($id), new PermissionTransformer());
    }

    /**
     * @param PermissionRequest $request
     * @param $id
     * @return response
     * author Fox
     */
    public function update(PermissionRequest $request, $id)
    {
        $this->permission->update($id, $request->all());

        return $this->noContent();

    }

    /**
     * @param PermissionRequest $request
     * @return response
     * author Fox
     */
    public function store(PermissionRequest $request)
    {

        $this->permission->store($request->all());

        return $this->noContent();
    }

    /**
     * @param $id
     * @return response
     * author Fox
     */
    public function destroy($id)
    {
        $str = explode(',',$id);
        foreach($str as $v){
            $this->permission->destroy($v);
        }

        return $this->noContent();
    }
}
