<?php

namespace App\Repositories;


use App\Navigation;

class NavigationRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(Navigation $navigation)
    {
        $this->model = $navigation;
    }


}
