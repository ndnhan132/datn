<?php

namespace App\Repositories\ParentRegister;

interface ParentRegisterRepositoryInterface
{
    public function pagination($startFrom, $recordPerPage, $is_received, $course_status, $select_subject, $select_course_level, $searchText, $searchCriterion);
    public function checkCanRegister($request);
    public function findWithData($parentRegisterId);
    public function confirm($courseId, $isConfirmed);

}
