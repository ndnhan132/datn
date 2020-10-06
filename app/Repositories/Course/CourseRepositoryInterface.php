<?php

namespace App\Repositories\Course;

interface CourseRepositoryInterface
{
    public function getHomeCourse($itemPerPage = 5);
}
