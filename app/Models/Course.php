<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Course extends Model
{
    use HasFactory;

    //* #define my functions
    /**
     * @Author: Nhan Nguyen Dinh
     * @Date: 2020-10-18 11:15:00
     * @Desc: lay giao vien nhan lop
     * @Return: model giao vien nhan lop hoac null
     */

    public function received()
    {
        // $res = $this->leftjoin('teacher_course_registrations', 'teacher_course_registrations.course_id', '=', 'courses.id')
        //             ->leftjoin('registration_statuses', 'registration_statuses.id', '=', 'teacher_course_registrations.registration_status_id')
        //             ->where('name', \App\Models\RegistrationStatus::RECEIVED_NAME)
        //             ->get();
        return $this->teacherCourseRegistrations->where('registration_status_id', \App\Models\RegistrationStatus::RECEIVED_ID)->first();
    }

    /**
     * @Author: Nhan Nguyen Dinh
     * @Date: 2020-10-24 22:06:27  *
     * @Desc:
     * @Return: model giao vien nhan lop hoac null
     */

    public function countWait()
    {
        return $this->teacherCourseRegistrations->where('registration_status_id', \App\Models\RegistrationStatus::PENDING_ID)->count();
    }

    //* #define Relationships
    public function subject()
    {
        return $this->belongsTo('App\Models\Subject');
    }

    // public function teachers()
    // {
    //     return $this->belongsToMany('App\Models\Teacher');
    // }

    public function teacherCourseRegistrations()
    {
        return $this->hasMany('App\Models\TeacherCourseRegistration');
    }

    public function courseLevel()
    {
        return $this->belongsTo('App\Models\CourseLevel');
    }

    public function TeacherLevel()
    {
        return $this->belongsTo('App\Models\TeacherLevel');
    }
}
