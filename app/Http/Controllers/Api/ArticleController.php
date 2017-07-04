<?php

namespace App\Http\Controllers\Api;

use App\Article;
use App\Http\Requests\ArticleRequest;
use App\Repositories\ArticleRepository;
use App\Transformers\ArticleTransformer;
use Illuminate\Http\Request;


class ArticleController extends ApiController
{
    protected $article;

    public function __construct(ArticleRepository $article)
    {
        parent::__construct();

        $this->article = $article;
    }

    /*
     * 文章列表
     */
    public function index()
    {
        $pageSize = intval(request('pagesize')) >0 ? request('pagesize') : 10;
        return $this->respondWithPaginator($this->article->page($pageSize), new ArticleTransformer);
    }

    /*
     * 文章保存
     * */
    public function store(ArticleRequest $request){

        $data = array_merge($request->all(), [
            'user_id'      => \Auth::id(),
            'last_user_id' => \Auth::id()
        ]);

        $data['is_draft']    = $data['is_draft'] === true ? 1 : 0;
        $data['is_original'] = $data['is_original'] === true ? 1 : 0;
        $data['published_at'] = isset($data['published_at']) ? $data['published_at'] : time();

        $this->article->store($data);

        if(isset($data['tag_id'])){
            $this->article->syncTag($data['tag_id']);
        }


        return $this->respondWithArray(['message'=>'文章已被创建！']);
        //return response()->json(['status'=>200,'msg'=>'success']);

    }

    /*
     * 文章修改
     * */
    public function show()
    {
        $id = request('id');
        $data = $this->article->getById($id);
        $data['tag_id'] = Article::find($id)->tags;
        return $data;
    }

    /**
     * @param $id
     * @return mixed
     * author Fox
     */
    public function edit($id){

        $data = $this->article->getById($id);

        $data['tag_id'] = Article::find($id)->tags;

        return $data;
    }
    /*
     * 文章更新
     * */
    public function update(ArticleRequest $request, $id)
    {
        $data = array_merge($request->all(), [
            'user_id'      => \Auth::id(),
            'last_user_id' => \Auth::id()
        ]);

        $data['is_draft']    = $data['is_draft'] === true ? 1 : 0;
        $data['is_original'] = $data['is_original'] === true ? 1 : 0;
        $data['published_at'] = isset($data['published_at']) ? $data['published_at'] : time();

        $this->article->update($id, $data);

        if(isset($data['tag_id'])){
            $this->article->syncTag($data['tag_id']);
        }

    }

    /*
     * 文章删除
     * */
    public function destroy($ids)
    {
        $id = $ids;
        $str = explode(',',$id);
        foreach($str as $v){
            $this->article->destroy($v);
        }
    }

    /*
     * 文章搜索
     */
    public function search(Request $request)
    {
        $map = array();
        $map['title'] = $request->input('para.title');
        $map['category'] = $request->input('para.category');
        return $this->article->search($map);
    }

    public function recycle()
    {
        $pageSize = intval(request('pagesize')) >0 ? request('pagesize') : 10;
        return $this->respondWithPaginator($this->article->pageWithDelete($pageSize), new ArticleTransformer);
    }

    public function recover($id)
    {
        $this->article->recover($id);
        return $this->noContent();
    }

    public function forcedelete($ids)
    {

        $id = $ids;
        $str = explode(',',$id);
        foreach($str as $v){
            $this->article->forceDel($v);
        }
        return $this->noContent();
    }

}
