<?php

namespace App\Repositories\Teacher;

interface TeacherRepositoryInterface
{
    public function pagination($startFrom, $recordPerPage);
}
