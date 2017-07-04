<?php

namespace App\Repositories;

use App\Discussion;

class DiscussionRepository
{
    use BaseRepository;

    protected $model;


    public function __construct(Discussion $discussion)
    {
        $this->model = $discussion;

    }



}
