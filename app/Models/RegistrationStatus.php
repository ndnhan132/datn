<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationStatus extends Model
{
    use HasFactory;

    const PENDING_ID      = 1; // dang cho
    const ELIGIBLE_ID     = 2; // du dieu kien
    const RECEIVED_ID     = 3; // da nhan
    const INELIGIBLE_ID   = 4; // ko da

    const PENDING_NAME    = 'pending';
    const ELIGIBLE_NAME   = 'eligible';
    const RECEIVED_NAME   = 'received';
    const INELIGIBLE_NAME = 'ineligible';

    public function teacherCourseRegistrations()
    {
        return $this->hasMany('App\Models\TeacherCourseRegistrations');
    }
}
