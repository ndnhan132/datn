<?php

namespace App\Repositories\TeacherCourseRegistration;

interface TeacherCourseRegistrationRepositoryInterface
{
    public function getByCourseId($courseId);
    public function confirmStatus($registrationId, $statusId);
    public function teacherRegisterCourse($courseId);
    public function deleteRegistration($courseId, $teacherId);
    public function pagination($startFrom, $recordPerPage, $select_registration_status, $searchText, $searchCriterion, $select_subject, $select_course_level, $teacherLevelId);
    public function getTotalNewRegistration();
}
