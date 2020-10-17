<?php

namespace App\Repositories\Teacher;

use App\Repositories\BaseRepository;
use App\Models\Teacher;

class TeacherRepository extends BaseRepository implements TeacherRepositoryInterface
{
    public function getModel()
    {
        return Teacher::class;
    }
}
