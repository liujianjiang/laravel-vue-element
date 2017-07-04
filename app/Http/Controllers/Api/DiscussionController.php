<?php

namespace App\Http\Controllers\Api;



use App\Repositories\DiscussionRepository;
use App\Transformers\DiscussionTransformer;

class DiscussionController extends ApiController
{
    protected $discussion;

    public function __construct(DiscussionRepository $discussion)
    {
        parent::__construct();
        $this->discussion = $discussion;
    }

    public function index()
    {

        $pageSize = intval(request('pagesize')) >0 ? request('pagesize') : 10;
        return $this->respondWithPaginator($this->discussion->page($pageSize), new DiscussionTransformer());
    }

    public function edit($id)
    {
        return $this->respondWithItem($this->discussion->getById($id), new DiscussionTransformer());
    }

    public function destroy($id)
    {
        $str = explode(',',$id);
        foreach($str as $v){
            $this->discussion->destroy($v);
        }
        return $this->noContent();
    }
}
