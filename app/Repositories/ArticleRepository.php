<?php

namespace App\Repositories;

use App\Article;
use App\Scopes\DraftScope;

class ArticleRepository
{
    use BaseRepository;

    protected $model;

    protected $visitor;

    public function __construct(Article $article, VisitorRepository $visitor)
    {
        $this->model = $article;

        $this->visitor = $visitor;
    }

    /**
     * Get the page of articles without draft scope.
     * 
     * @param  integer $number
     * @param  string  $sort
     * @param  string  $sortColumn
     * @return collection
     */
    public function page($number = 20, $sort = 'desc', $sortColumn = 'created_at')
    {
        $this->model = $this->checkAuthScope();
        return $this->model->orderBy($sortColumn, $sort)->paginate($number);
    }

    /**
     * @param int $number
     * @param string $sort
     * @param string $sortColumn
     * @return mixed
     * author Fox
     */
    public function pageWithDelete($number = 20, $sort = 'desc', $sortColumn = 'created_at')
    {
        $this->model = $this->checkAuthScope();
        return $this->model->onlyTrashed()->orderBy($sortColumn, $sort)->paginate($number);
    }

    /**
     * Get the article record without draft scope.
     * 
     * @param  int $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->model->withoutGlobalScope(DraftScope::class)->findOrFail($id);
    }

    /**
     * Update the article record without draft scope.
     * 
     * @param  int $id
     * @param  array $input
     * @return boolean
     */
    public function update($id, $input)
    {
        $this->model = $this->model->withoutGlobalScope(DraftScope::class)->findOrFail($id);

        return $this->save($this->model, $input);
    }

    /**
     * Get the article by article's slug.
     * The Admin can preview the article if the article is drafted.
     *
     * @param $slug
     * @return object
     */
    public function getBySlug($slug)
    {
        $this->model = $this->checkAuthScope();

        $article = $this->model->where('slug', $slug)->firstOrFail();

        $article->increment('view_count');

        $this->visitor->log($article->id);

        return $article;
    }

    /**
     * Check the auth and the model without global scope when user is the admin.
     * 
     * @return Model
     */
    public function checkAuthScope()
    {
        if (auth()->check() && auth()->user()->is_admin) {
            $this->model = $this->model->withoutGlobalScope(DraftScope::class);
        }

        return $this->model;
    }

    /**
     * Sync the tags for the article.
     *
     * @param  array $tags
     * @return Paginate
     */
    public function syncTag(array $tags)
    {
        $this->model->tags()->sync($tags);
    }

    /**
     * Search the articles by the keyword.
     * 
     * @param  array $map
     * @return collection
     */
    public function search($map)
    {
        $title = $map['title'];
        $category = $map['category'];
        return $this->model
                    ->where([
                        ['title', 'like', "%{$title}%"],
                        ['category_id', '=', $category]
                    ])
                    ->orderBy('published_at', 'desc')
                    ->paginate(10);
    }

    /**
     * Delete the draft article.
     *
     * @param int $id
     * @return boolean
     */
    public function destroy($id)
    {
        return $this->getById($id)->delete();
    }

    public function recover($id)
    {
        return $this->model->where('id', $id)->restore();
    }

    public function forceDel($id)
    {
        return $this->model->where('id', $id)->forceDelete();
    }

}
