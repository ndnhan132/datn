<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Teacher extends Authenticatable
{
    use HasFactory, Notifiable;
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //* #define my functions
    /**
     * @Author: Nhan Nguyen Dinh
     * @function:
     * @Date: 2020-11-29 00:27:59
     * @Desc:   check status account
     * @Params1:
     * @Return:
     */
    public function isConfirmed()
    {
        return $this->teacher_account_status_id == \App\Models\TeacherAccountStatus::CONFIRMED_ID;
    }
    public function isIneligible()
    {
        return $this->teacher_account_status_id == \App\Models\TeacherAccountStatus::INELIGIBLE_ID;
    }
    public function isRequestVerification()
    {
        return $this->teacher_account_status_id == \App\Models\TeacherAccountStatus::REQUEST_VERIFICATION_ID;
    }

    /**
     * @Author: Nhan Nguyen Dinh
     * @Date: 2020-10-18 16:40:09
     * @Desc: lay anh dai dien
     * @Return: src anh dai dien
     */
    public function getAvatarSrc()
    {
        $res = $this->images->where('image_type', \App\Models\Image::TEACHER_AVATAR)->first();
        return $res->src ?? asset('/images/noavatar.jpg');
    }

    /**
     * @Author: Nhan Nguyen Dinh
     * @functon isActive()
     * @Date: 2020-11-01 04:46:34
     * @Desc:
     * @Return:
     */
    // public function isActive()
    // {
        // return $this->flag_is_checked && $this->flag_is_teacher;
    // }
/**
 * @Author: Nhan Nguyen Dinh
 * @function: canSendRequestConfirmation
 * @Date: 2020-11-28 23:42:40
 * @Desc:
 * @Params1:
 * @Return:
 */

    public function canSendRequestConfirmation(){
        if(!$this->isConfirmed()){
            $lastSentAt = $this->request_confirmation_at ?? 0;
            $diffTime = time() - $lastSentAt;
            $threeDays = 3 * 24 * 60 * 60;
            $threeDays = 20;
            if($diffTime >  $threeDays) {
                return true;
            }
        }
        return false;
    }


    /**
     * @Author: Nhan Nguyen Dinh
     * @function getGenderAndLevel()
     * @Date: 2020-11-01 10:32:36
     * @Desc:
     * @Params1:
     * @Return:
     */

    public function getGenderAndLevel()
    {
        $gender = "";
        if($this->is_male) {
            $gender = "Nam ";
        }
        else {
            $gender = "Nữ ";
        }
        $str = $gender. ($this->teacherLevel->display_name ?? '');
        $str = strtolower($str);
        $str = ucfirst($str);
        return $str;
    }

    /**
     * @Author: Nhan Nguyen Dinh
     * @function: isRegisteredThisCourse($courseId)
     * @Date: 2020-11-01 15:36:43
     * @Desc:
     * @Params1:
     * @Return:
     */

    public function isRegisteredThisCourse($courseId)
    {
        return $this->teacherCourseRegistrations()->where('course_id', $courseId)->first();
    }

    /**
     * @Author: Nhan Nguyen Dinh
     * @function: getIdentityCardImages()
     * @Date: 2020-11-20 22:20:42
     * @Desc:
     * @Params1:
     * @Return:
     */

    public function getIdentityCardImages()
    {
        $res = $this->images->where('image_type', \App\Models\Image::TEACHER_IDENTITY_CARD)->all();
        return $res;
    }

    /**
     * @Author: Nhan Nguyen Dinh
     * @function: getDegreeImages
     * @Date: 2020-11-20 22:45:59
     * @Desc:
     * @Params1:
     * @Return:
     */
    public function getDegreeImages()
    {
        $res = $this->images->where('image_type', \App\Models\Image::TEACHER_DEGREE)->all();
        return $res;
    }
    /**
     * @Author: Nhan Nguyen Dinh
     * @function: getDisplayTution()
     * @Date: 2020-11-21 11:19:39
     * @Desc:
     * @Params1:
     * @Return:
     */
    public function getDisplayTution()
    {
        if(!is_numeric($this->reference_tuition)) return $this->reference_tuition;
        return number_format($this->reference_tuition, 0, ",", ".");
    }

    /**
     * @Author: Nhan Nguyen Dinh
     * @function: getMyReceivedRegistration()
     * @Date: 2020-11-21 15:33:48
     * @Desc:
     * @Params1:
     * @Return:
     */
    public function getMyReceivedRegistration()
    {
        // $myId = Auth::guard('teacher')->user()->id;
        $myId = $this->id;
        $res = $this->teacherCourseRegistrations
                    ->where('teacher_id', $myId)
                    ->where('registration_status_id', \App\Models\RegistrationStatus::RECEIVED_ID)
                    ->sortByDesc('id')
                    ->all();
        return $res ?? false;
    }
/**
 * @Author: Nhan Nguyen Dinh
 * @function:getAge
 * @Date: 2020-11-26 00:53:34
 * @Desc:
 * @Params1:
 * @Return:
 */

 public function getAge()
 {
     $year  = $this->year_of_birth;
     if(is_numeric($year)){
         try {
             return date('Y') - $year;
         } catch(Exception $e){
            return false;
         }
     }
     return false;
 }
 /**
  * @Author: Nhan Nguyen Dinh
  * @function:
  * @Date: 2020-11-29 01:53:09
  * @Desc:
  * @Params1:
  * @Return:
  */
  public function getDisplaySubject()
  {
      if($this->subjects){
            $str = '';
            foreach($this->subjects as $key => $sbj){
                if($key != 0) $str .= ' - ';
                $str .= $sbj->display_name;
            }
            return $str;
      }
      return 'chưa chập nhật';
  }
/**
 * @Author: Nhan Nguyen Dinh
 * @function:
 * @Date: 2020-11-29 10:33:52
 * @Desc:
 * @Params1:
 * @Return:
 */

 public function getDisplayCourseLevel()
 {
    if($this->courseLevels){
        $str = '';
        foreach($this->courseLevels as $key => $lvl){
            if($key != 0) $str .= ' - ';
            $str .= $lvl->display_name;
        }
        return $str;
    }
    return 'chưa chập nhật';
 }




    //* #define RelationshipsP
    // public function courses()
    // {
    //     return $this->belongsToMany('App\Models\Courses');
    // }

    public function teacherCourseRegistrations()
    {
        return $this->hasMany('App\Models\TeacherCourseRegistration');
    }

    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }

    public function teacherLevel()
    {
        return $this->belongsTo('App\Models\TeacherLevel');
    }

    public function teacherAccountStatus()
    {
        return $this->belongsTo('App\Models\TeacherAccountStatus');
    }

    public function subjects()
    {
        return $this->belongsToMany('App\Models\Subject', 'subject_teachers');
    }
    public function courseLevels()
    {
        return $this->belongsToMany('App\Models\CourseLevel', 'course_level_teachers');
    }



}
