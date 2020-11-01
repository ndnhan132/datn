<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
     * @Date: 2020-10-18 16:40:09
     * @Desc: lay anh dai dien
     * @Return: src anh dai dien
     */
    public function getAvatarSrc()
    {
        $res = $this->images->where('image_type', \App\Models\Image::TEACHER_AVATAR)->first();
        return $res->src ?? '#';
    }

    /**
     * @Author: Nhan Nguyen Dinh
     * @functon isActive()
     * @Date: 2020-11-01 04:46:34
     * @Desc:
     * @Return:
     */
    public function isActive()
    {
        return $this->flag_is_checked && $this->flag_is_active;
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
        $str = $gender. $this->teacherLevel->display_name ?? '';
        $str = strtolower($str);
        $str = ucfirst($str);
        return $str;
    }


    //* #define Relationships
    // public function courses()
    // {
    //     return $this->belongsToMany('App\Models\Courses');
    // }

    public function teacherCourseRegistrations()
    {
        return $this->hasMany('App\Models\TeacherCourseRegistrations');
    }

    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }

    public function teacherLevel()
    {
        return $this->belongsTo('App\Models\TeacherLevel');
    }
}
