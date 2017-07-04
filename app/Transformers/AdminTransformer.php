<?php

namespace App\Transformers;

use App\Admin;
use League\Fractal\TransformerAbstract;

class AdminTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['role'];

    public function transform(Admin $admin)
    {
        return [
            'id' => $admin->id,
            'name' => $admin->name,
            'email' => $admin->email,
            'avatar' => $admin->avatar,
            'is_super' => $admin->is_super,
            'created_at' => $admin->created_at->toDateTimeString(),
        ];
    }

    public function includeRole(Admin $admin)
    {
        return $this->collection($admin->roles, new RoleTransformer());
    }
}
