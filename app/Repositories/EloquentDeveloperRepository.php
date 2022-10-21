<?php

namespace App\Repositories;


use App\Models\Developer;

class EloquentDeveloperRepository extends EloquentRepository
{
    /**
     * @var Developer
     */
    protected $model;


    /**
     * EloquentDeveloperRepository constructor.
     * @param Developer $developer
     */
    public function __construct(Developer $developer)
    {
        $this->model = $developer;
    }

}
