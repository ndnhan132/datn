<?php

namespace App\Repositories\Course;

interface CourseRepositoryInterface
{
    public function getHomeCourse($itemPerPage = 5);
    public function pagination($startFrom, $recordPerPage);
    public function confirm($courseId, $isConfirmed);
}
