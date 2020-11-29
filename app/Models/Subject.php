<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    public function courses()
    {
        return $this->hasMany('App\Models\Courses');
    }

    public function teachers()
    {
        return $this->belongsToMany('App\Models\Teacher', 'subject_teachers');
    }
}
