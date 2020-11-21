<?php

namespace App\Repositories\TeacherCourseRegistration;

interface TeacherCourseRegistrationRepositoryInterface
{
    public function getByCourseId($courseId);
    public function confirmStatus($registrationId, $statusId);
    public function teacherRegisterCourse($courseId);
    public function deleteRegistration($courseId, $teacherId);
}
