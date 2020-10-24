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
