<?php

namespace App\Repositories\Course;

interface CourseRepositoryInterface
{
    public function getHomeCourse($itemPerPage = 5);
    public function pagination($startFrom, $recordPerPage, $is_received, $course_status, $select_subject, $select_course_level, $searchText, $searchCriterion);
    public function teacherCourseRegistrationPagination($startFrom, $recordPerPage);
    public function confirm($courseId, $isConfirmed);
    public function getNewClassesWithPagination($startFrom, $recordPerPage); // front page
    public function findBySlug($slug);
    public function getWithPagination($startFrom, $recordPerPage, $type, $confirmedRequired);
    public function findWithData($courseId);
    public function getTotalNewCourse();
}
