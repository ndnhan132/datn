<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherAccountStatus extends Model
{
    use HasFactory;
    const CONFIRMED_ID      = 1; // dang cho
    const INELIGIBLE_ID     = 2; // du dieu kien
    const REQUEST_VERIFICATION_ID     = 3; // da nhan

    const CONFIRMED_NAME    = 'CONFIRMED';
    const REQUEST_VERIFICATION_NAME   = 'REQUEST_VERIFICATION';
    const INELIGIBLE_NAME = 'INELIGIBLE';

    public function teachers()
    {
        return $this->hasMany('App\Models\Teachers');
    }
}
