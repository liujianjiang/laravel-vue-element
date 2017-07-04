<?php

namespace App\Http\Controllers\Api;
use App\Http\Requests\CategoryRequest;
use App\Repositories\CategoryRepository;
use App\Transformers\CategoryTransformer;

class CategoryController extends ApiController
{
    protected $category;

    public function __construct(CategoryRepository $category)
    {
        parent::__construct();
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageSize = intval(request('pagesize')) >0 ? request('pagesize') : 10;
        return $this->respondWithPaginator($this->category->page($pageSize), new CategoryTransformer());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param CategoryRequest $request
     * @return \App\Repositories\User
     * author Fox
     */
    public function store(CategoryRequest $request)
    {
        $this->category->store($request->all());

        return $this->noContent();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $this->respondWithItem($this->category->getById($id), new CategoryTransformer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request,$id)
    {
        $this->category->update($id, $request->all());

        return $this->noContent();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $str = explode(',',$id);
        foreach($str as $v){
            $this->category->destroy($v);
        }
    }

    public function getAllList()
    {
        return $this->respondWithCollection($this->category->all(), new CategoryTransformer);
    }
}
