<?php

namespace App\Repositories;

use App\Admin;

class AdminRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(Admin $admin)
    {
        $this->model = $admin;
    }

    public function page($number = 10, $sort = 'desc', $sortColumn = 'created_at')
    {
        return $this->model->orderBy($sortColumn, $sort)->paginate($number);
    }

    public function store($payload = [])
    {
        return $this->model->create([
            'name' => $payload['name'],
            'email' => $payload['email'],
            'avatar' => $payload['avatar'],
            'password' => bcrypt($payload['password']),
            'is_super' => $payload['is_super']
        ]);

    }

    public function createRoles($adminUser, $roles)
    {
        $adminUser->roles()->attach($roles);
    }


}
