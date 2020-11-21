<?php

namespace App\Repositories\Course;

interface CourseRepositoryInterface
{
    public function getHomeCourse($itemPerPage = 5);
    public function pagination($startFrom, $recordPerPage);
    public function teacherCourseRegistrationPagination($startFrom, $recordPerPage);
    public function confirm($courseId, $isConfirmed);
    public function getNewClassesWithPagination($startFrom, $recordPerPage); // front page
    public function findBySlug($slug);
    public function getWithPagination($startFrom, $recordPerPage, $type, $confirmedRequired);
    public function findWithData($courseId);
}
