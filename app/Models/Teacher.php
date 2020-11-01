<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

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

    public function TeacherLevel()
    {
        return $this->belongsTo('App\Models\TeacherLevel');
    }
}
