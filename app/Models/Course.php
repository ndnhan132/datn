<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

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

    /**
     * @Author: Nhan Nguyen Dinh
     * @function getRequiredGenderAndLevel
     * @Date: 2020-11-01 09:05:14
     * @Desc:
     * @Params1:
     * @Return:
     */
    public function getRequiredGenderAndLevel()
    {
        $gender = "";
        if($this->teacher_gender == "MALE") {
            $gender = "Nam ";
        }
        elseif($this->teacher_gender == "FEMALE"){
            $gender = "Nữ ";
        }
        $str = $gender. $this->teacherLevel->display_name ?? '';
        $str = strtolower($str);
        $str = ucfirst($str);
        return $str;
    }

    /**
     * @Author: Nhan Nguyen Dinh
     * @function: getSubjectAndLevel()
     * @Date: 2020-11-15 11:11:21
     * @Desc:
     * @Params1:
     * @Return:
     */
    public function getSubjectAndLevel()
    {
        $subj = '';
        $lvl  = '';
        if($this->subject) $subj .= $this->subject->display_name;
        if($this->other_subject) $subj .= ', ' . $this->other_subject;
        if($this->courseLevel) $lvl .= $this->courseLevel->display_name;
        if($this->otherLevel) $lvl .= ', ' . $this->other_teacher_level;

        return $subj . ' - ' . $lvl;
    }

    /**
     * @Author: Nhan Nguyen Dinh
     * @function: getDisplayTution()
     * @Date: 2020-11-15 11:27:47
     * @Desc:
     * @Params1:
     * @Return:
     */
    public function getDisplayTution()
    {
        if(!is_numeric($this->tuition_per_session)) return $this->tuition_per_session;
        return number_format($this->tuition_per_session, 0, ",", ".");
    }

    /**
     * @Author: Nhan Nguyen Dinh
     * @function: getDisplaySubject
     * @Date: 2020-11-15 16:26:56
     * @Desc:
     * @Params1:
     * @Return:
     */
    public function getDisplaySubject()
    {
        $subj = '';
        if($this->subject) $subj .= $this->subject->display_name;
        if($this->other_subject) $subj .= ', ' . $this->other_subject;
        return $subj;
    }

    /**
     * @Author: Nhan Nguyen Dinh
     * @function: getDisplayCourseLevel()
     * @Date: 2020-11-15 16:28:46
     * @Desc:
     * @Params1:
     * @Return:
     */

    public function getDisplayCourseLevel()
    {
        $lvl  = '';
        if($this->courseLevel) $lvl .= $this->courseLevel->display_name;
        if($this->otherLevel) $lvl .= ', ' . $this->other_teacher_level;

        return $lvl;
    }
/**
 * @Author: Nhan Nguyen Dinh
 * @function:getDisplayTimeAll()
 * @Date: 2020-11-25 23:21:13
 * @Desc:
 * @Params1:
 * @Return:
 */

    public function getDisplayTimeAll()
    {
        $time =  $this->time_working;
        if($this->session_per_week){
            $time .= ', '  . $this->session_per_week . ' buổi/tuần';
        }
        if($this->time_per_session){
            $time .= ', ' . $this->time_per_session .' phút/buổi';
        }
        $time .= '.';
        return $time;
    }

    /**
     * @Author: Nhan Nguyen Dinh
     * @function:  getDisplayTeacherLevel()
     * @Date: 2020-11-25 23:29:17
     * @Desc:
     * @Params1:
     * @Return:
     */

    public function getDisplayTeacherLevel()
    {
        $lv = '';
        if($this->teacherLevel) {
            $lv .= $this->teacherLevel->display_name;
        }
        if($this->other_teacher_level){
            $lv .= ', ' . $this->other_teacher_level;
        }
        $lv .= '.';
        return $lv;
    }
/**
 * @Author: Nhan Nguyen Dinh
 * @function:  getDisplayTeacherLevelAndGender
 * @Date: 2020-11-25 23:31:27
 * @Desc:
 * @Params1:
 * @Return:
 */

 public function getDisplayTeacherLevelAndGender()
 {
    $gender = "";
    if($this->teacher_gender == "MALE") {
        $gender = "Nam ";
    }
    elseif($this->teacher_gender == "FEMALE"){
        $gender = "Nữ ";
    }

    $str = $gender. $this->getDisplayTeacherLevel();
    $str = strtolower($str);
    $str = ucfirst($str);
    return $str;
 }
/**
 * @Author: Nhan Nguyen Dinh
 * @function:
 * @Date: 2020-12-02 22:21:31
 * @Desc:
 * @Params1:
 * @Return:
 */
    public function isConfirmed()
    {
        //đã xác nhận
        return boolval($this->flag_is_confirmed);
    }
    public function isUnConfirmed()
    {
        // đã xác nhận và đã đọc
        return !$this->flag_is_confirmed && $this->flag_is_checked;
    }
    public function isNew()
    {
        // chưa đọc
        return !$this->flag_is_confirmed && !$this->flag_is_checked;
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

    public function teacherLevel()
    {
        return $this->belongsTo('App\Models\TeacherLevel');
    }
    public function parentRegisters()
    {
        return $this->hasMany('App\Models\ParentRegister');
    }

    //* #define Accessors
    public function getCreatedAtAttribute($value)
    {
        return (new Carbon($value))->setTimeZone('Asia/Ho_Chi_Minh')->isoFormat('HH:mm DD/MM/YYYY');
    }
}
