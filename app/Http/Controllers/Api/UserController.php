<?php

namespace App\Http\Controllers\Api;

use App\Repositories\UserRepository;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends ApiController
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    public function index()
    {
        $pageSize = intval(request('pagesize')) >0 ? request('pagesize') : 10;
        return $this->respondWithPaginator($this->user->page($pageSize), new UserTransformer());
    }
}
