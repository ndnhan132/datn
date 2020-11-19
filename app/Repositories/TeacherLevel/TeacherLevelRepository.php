<?php

namespace App\Repositories\TeacherLevel;

use App\Repositories\BaseRepository;
use App\Models\TeacherLevel;

class TeacherLevelRepository extends BaseRepository implements TeacherLevelRepositoryInterface
{
    public function getModel()
    {
        return TeacherLevel::class;
    }
}
