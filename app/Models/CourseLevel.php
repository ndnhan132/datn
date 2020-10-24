<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseLevel extends Model
{
    use HasFactory;

    // *#define Relationships
    public function courses()
    {
        return $this->hasMany('App\Models\Courses');
    }
}
