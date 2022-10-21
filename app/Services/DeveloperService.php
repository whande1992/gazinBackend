<?php

namespace App\Services;

use App\Repositories\EloquentDeveloperRepository;
use Carbon\Carbon;
use Carbon\Traits\Date;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class DeveloperService
{
    protected EloquentDeveloperRepository $repository;

    /**
     * DeveloperService constructor.
     * @param EloquentDeveloperRepository $developerRepository
     */
    public function __construct(EloquentDeveloperRepository $developerRepository)
    {
        $this->repository = $developerRepository;
    }


    /**
     * @param $request
     * @return mixed
     */
    public function getDevelopers($request): mixed
    {
        return $this->repository->all($request);
    }

    /**
     * @param $search
     * @return mixed
     */
    public function searchDeveloper($search): mixed
    {
        return $this->repository->search($search);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getDeveloperById(int $id): mixed
    {
        return $this->repository->find($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createDeveloper(array $data): mixed
    {
        $data['age'] = $this->calculateAge($data['birth_date']);

        return $this->repository->create($data);
    }

    /**
     * @param int $id
     * @return int
     */
    public function deleteDeveloper(int $id): int
    {
        return $this->repository->delete($id);
    }

    /**
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function updateDeveloper(array $data, int $id): mixed
    {
        $data['age'] = $this->calculateAge($data['birth_date']);

        return $this->repository->update($data, $id);
    }

    /**
     * @Annotation Format yyy-mm-dd
     * @param $birth_date
     * @return int age to developer
     */
    private function calculateAge($birth_date): int
    {
        return Carbon::create($birth_date)->diffInYears(Carbon::now());
    }

}
