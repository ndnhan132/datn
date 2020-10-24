<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    const TEACHER_AVATAR        = 'TEACHER_AVATAR';
    const TEACHER_IDENTITY_CARD = 'TEACHER_IDENTITY_CARD';
    const TEACHER_DEGREE        = 'TEACHER_DEGREE';

    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher');
    }
}
