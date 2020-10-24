<?php

namespace App\Repositories\TeacherCourseRegistration;

interface TeacherCourseRegistrationRepositoryInterface
{
    public function getByCourseId($courseId);
}