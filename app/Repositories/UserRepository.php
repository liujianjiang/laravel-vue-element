<?php
namespace App\Repositories;

use App\User;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository
{

    use BaseRepository;

    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

}