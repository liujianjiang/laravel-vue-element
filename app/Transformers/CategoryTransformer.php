<?php

namespace App\Transformers;

use App\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    public function transform(Category $category)
    {
        return [
            'id'            => $category->id,
            'name'          => $category->name,
            'path'          => $category->path,
            'description'   => $category->description,
            'image_url'        => $category->image_url,
            'created_at'    => $category->created_at->toDateTimeString(),
        ];
    }
}
