<?php

namespace App\Http\Controllers\Api;

use App\Admin;

use App\Http\Requests\AdminRequest;
use App\Repositories\AdminRepository;
use App\Transformers\AdminTransformer;
use Illuminate\Http\Request;


class AdminController extends ApiController
{
    protected $admin;

    public function __construct(AdminRepository $admin)
    {
        parent::__construct();
        $this->admin = $admin;
    }

    public function index()
    {


        $pageSize = intval(request('pagesize')) >0 ? request('pagesize') : 10;
        return $this->respondWithPaginator($this->admin->page($pageSize), new AdminTransformer());
    }

    public function store(AdminRequest $request)
    {
        $adminUser = $this->admin->store($request->all());

        $this->admin->createRoles($adminUser,$request->get('roles'));

        return $this->noContent();
    }

    public function edit($id)
    {
        return $this->respondWithItem($this->admin->getById($id), new AdminTransformer());
    }


    public function update(AdminRequest $request, $id)
    {
        $adminUser = $this->admin->getById($id);

        $this->admin->update($id, $request->all());


       // $this->admin->createRoles($adminUser,$request->get('roles'));
        $adminUser->roles()->sync($request->get('roles'));

        return $this->noContent();
    }


    public function destroy($id)
    {
        $str = explode(',',$id);
        foreach($str as $v){
            $this->admin->destroy($v);
        }
        return $this->noContent();
    }
}
