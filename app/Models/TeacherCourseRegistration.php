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
        // return $this->registration_status_id == \App\Models\RegistrationStatus::RECEIVED_ID;
        return false;
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
     * @function:
     * @Date: 2020-12-05 22:26:09
     * @Desc:
     * @Params1:
     * @Return:
     */

    public function getStatusColor()
    {
        $status = $this->registration_status_id;
        switch ($this->registration_status_id) {
            case \App\Models\RegistrationStatus::INELIGIBLE_ID:
                return 'secondary';
                break;
            case \App\Models\RegistrationStatus::PENDING_ID:
                return 'warning';
                break;
            // case \App\Models\RegistrationStatus::RECEIVED_ID:
            //     return 'success';
            //     break;
            case \App\Models\RegistrationStatus::ELIGIBLE_ID:
                return 'info';
                break;
            default:
                return '';
                break;
        }
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
