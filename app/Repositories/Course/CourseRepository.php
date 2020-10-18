<?php

namespace App\Repositories\Course;

use App\Repositories\BaseRepository;
use App\Models\Course;

class CourseRepository extends BaseRepository implements CourseRepositoryInterface
{
    public function getModel()
    {
        return Course::class;
    }

    public function getHomeCourse($itemPerPage = 5)
    {
        return $this->model->orderBy('created_at', 'asc')
                           ->limit($itemPerPage)
                           ->offset(0)
                           ->get();
    }

    public function pagination($startFrom, $recordPerPage)
    {
        return $this->model->orderBy('id', 'DESC')
                    ->offset($startFrom)
                    ->limit($recordPerPage)
                    ->get();
    }

    public function confirm($courseId, $isConfirmed)
    {
        $course = $this->model->find($courseId);
        $course->confirmed = $isConfirmed;
        return $course->save();
    }


}
