<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherCourseRegistration extends Model
{
    use HasFactory;

    //* #define my functions

    /**
     * @Author: Nhan Nguyen Dinh
     * @Date: 2020-10-18 17:16:28
     * @Desc: kiem tra tinh trang cua cac dang ky
     * @Return: true / false
     */
    public function isReceived()
    {
        return $this->registration_status_id == \App\Models\RegistrationStatus::RECEIVED_ID;
    }
    public function isPendding()
    {
        return $this->registration_status_id == \App\Models\RegistrationStatus::PENDING_ID;
    }
    public function isEligible()
    {
        return $this->registration_status_id == \App\Models\RegistrationStatus::ELIGIBLE_ID;
    }
    public function isIneligible()
    {
        return $this->registration_status_id == \App\Models\RegistrationStatus::INELIGIBLE_ID;
    }

    //* #define Relationships
    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher');
    }
    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }
    public function registrationStatus()
    {
        return $this->belongsTo('App\Models\RegistrationStatus');
    }
}
