<?php

namespace App\Repositories\RegistrationStatus;

use App\Repositories\BaseRepository;
use App\Models\RegistrationStatus;

class RegistrationStatusRepository extends BaseRepository implements RegistrationStatusRepositoryInterface
{
    public function getModel()
    {
        return RegistrationStatus::class;
    }
    public function findByName($name)
    {
        return $this->model->where('name', $name)->first();
    }
}
