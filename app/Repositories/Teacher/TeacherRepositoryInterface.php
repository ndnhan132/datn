<?php

namespace App\Repositories\Teacher;

interface TeacherRepositoryInterface
{
    public function pagination($startFrom, $recordPerPage);
    // public function markAsChecked($teacher);
    public function confirm($teacherId, $isActive);
    public function findByEmail($email);
    public function updateGeneral($request);
    public function updatePassword($request);
    public function updateEducation($request);
    public function verifyEmail($id);
}
