<?php

namespace App\Repositories\Teacher;

interface TeacherRepositoryInterface
{
    public function pagination($startFrom, $recordPerPage);
    // public function markAsChecked($teacher);
    public function confirm($teacherId, $isActive);
}
