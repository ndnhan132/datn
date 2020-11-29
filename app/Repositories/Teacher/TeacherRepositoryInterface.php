<?php

namespace App\Repositories\Teacher;

interface TeacherRepositoryInterface
{
    public function pagination($startFrom, $recordPerPage, $teacherAccountStatus, $selectTeacherLevel, $searchText, $searchCriterion);
    // public function markAsChecked($teacher);
    public function confirm($teacherId, $isActive);
    public function findByEmail($email);
    public function updateGeneral($request);
    public function updatePassword($request);
    public function updateEducation($request);
    public function verifyEmail($id);
    public function sendRequestConfirmation($teacherId);
    public function getFrontListWithPagination($startFrom, $recordPerPage, $teacherLevelId = false, $gender = 'BOTH',$courseLevelId = false, $subjectId = false);
}
