<?php

namespace App\Repositories\CourseLevel;

use App\Repositories\BaseRepository;
use App\Models\CourseLevel;

class CourseLevelRepository extends BaseRepository implements CourseLevelRepositoryInterface
{
    public function getModel()
    {
        return CourseLevel::class;
    }
}
