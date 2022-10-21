<?php

namespace App\Services;

use App\Repositories\EloquentLevelRepository;
use Illuminate\Database\Eloquent\Collection;

class LevelService
{
    protected EloquentLevelRepository $repository;

    public function __construct(EloquentLevelRepository $levelRepository)
    {
        $this->repository = $levelRepository;
    }


    /**
     * @param $request
     * @return mixed
     */
    public function getLevels($request): mixed
    {
        return $this->repository->all($request);
    }

    /**
     * @param $search
     * @return mixed
     */
    public function searchLevel($search): mixed
    {
        return $this->repository->search($search);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getLevelById(int $id): mixed
    {
        return $this->repository->find($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createLevel(array $data): mixed
    {
        return $this->repository->create($data);
    }

    /**
     * @param int $id
     * @return int
     */
    public function deleteLevel(int $id): int
    {
        return $this->repository->delete($id);
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function updateLevel(array $data, int $id): mixed
    {
        return $this->repository->update($data, $id);
    }

}
