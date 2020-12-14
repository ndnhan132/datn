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
    public function getWithPagination($startFrom, $recordPerPage, $type, $confirmedRequired, $select_teacher_level, $select_course_level,$select_subject);
    public function findWithData($courseId);
    public function getTotalNewCourse();
    public function getByCourseLevelId($courseLevelId);
    public function getByCourseLevelIdAndSubject($courseLevelId, $subjectId);
}
