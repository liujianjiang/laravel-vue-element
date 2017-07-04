<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TagRequest;
use App\Repositories\TagRepository;
use App\Transformers\TagTransformer;
use Illuminate\Http\Request;


class TagController extends ApiController
{
    protected $tag;


    public function __construct(TagRepository $tag)
    {
        parent::__construct();
        $this->tag = $tag;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageSize = intval(request('pagesize')) >0 ? request('pagesize') : 10;
        return $this->respondWithPaginator($this->tag->page($pageSize), new TagTransformer());
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
     * @param TagRepository $request
     * author Fox
     */
    public function store(TagRequest $request)
    {

        $this->tag->store($request->all());

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
        return $this->respondWithItem($this->tag->getById($id), new TagTransformer());
    }

    /**
     * @param TagRequest $request
     * @param $id
     * author Fox
     */
    public function update(TagRequest $request,$id)
    {

        $this->tag->update($id, $request->all());

        return $this->noContent();
    }

    /**
     * @param Request $request
     * @return response
     * author Fox
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $str = explode(',',$id);
        foreach($str as $v){
            $this->tag->destroy($v);
        }
    }

    /**
     * author Fox
     */
    public function getAllList()
    {
        return $this->tag->all();
    }
}
