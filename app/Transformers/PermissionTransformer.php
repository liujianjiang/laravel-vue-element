<?php

namespace App\Transformers;

use App\Permission;
use League\Fractal\TransformerAbstract;

class PermissionTransformer extends TransformerAbstract
{
    public function transform(Permission $permission)
    {
        return [

            'id' => $permission->id,
            'fid' => $permission->fid,
            'name' => $permission->name,
            'display_name' => $permission->display_name,
            'is_menu' => $permission->is_menu,
            'sort' => $permission->sort,
            'description' => $permission->description,
            'created_at' => $permission->created_at->toDateTimeString(),
        ];
    }
}
