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

    /**
     * @Author: Nhan Nguyen Dinh
     * @Date: 2020-10-25 16:11:38
     * @Desc: Đăng ký được thay đổi điều kiện trong trường hợp thay đổi cho đăng ký đã nhận hoặc khoá học chưa ai nhận
     * @Return: boolean
     */
    public function canChangeStatus()
    {
        return !( (!$this->isReceived()) && $this->course->received() );
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
