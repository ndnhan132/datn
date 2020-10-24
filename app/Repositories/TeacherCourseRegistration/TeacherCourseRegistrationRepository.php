<?php

namespace App\Repositories\TeacherCourseRegistration;

use App\Repositories\BaseRepository;
use App\Models\TeacherCourseRegistration;

class TeacherCourseRegistrationRepository extends BaseRepository implements TeacherCourseRegistrationRepositoryInterface
{
    public function getModel()
    {
        return TeacherCourseRegistration::class;
    }

    public function getByCourseId($courseId)
    {
        // return $this->model->where('course_id', $courseId);
    }
}
