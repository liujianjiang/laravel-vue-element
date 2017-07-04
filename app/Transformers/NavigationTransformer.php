<?php

namespace App\Transformers;

use App\Navigation;
use League\Fractal\TransformerAbstract;

class NavigationTransformer extends TransformerAbstract
{
    public function transform(Navigation $navigation)
    {
        return [
            'id'            => $navigation->id,
            'name'          => $navigation->name,
            'url'           => $navigation->url,
            'sort'          => $navigation->sort,
            'created_at'    => $navigation->created_at->toDateTimeString(),
        ];
    }
}
