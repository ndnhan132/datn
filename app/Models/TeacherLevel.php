<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherLevel extends Model
{
    use HasFactory;

    //* #define Relationships
    public function courses()
    {
        return $this->hasMany('App\Models\Courses');
    }

    public function teachers()
    {
        return $this->hasMany('App\Models\Teachers');
    }
}
