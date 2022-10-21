<?php

namespace App\Repositories;

use App\Models\Level;

class EloquentLevelRepository extends EloquentRepository
{
    /**
     * @var Level
     */
    protected $model;


    /**
     * EloquentLevelRepository constructor.
     * @param Level $level
     */
    public function __construct(Level $level)
    {
        $this->model = $level;
    }


}
