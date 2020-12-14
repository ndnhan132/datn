<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentRegister extends Model
{
    use HasFactory;

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


    public function getDisplayTution()
    {
        if(!is_numeric($this->tuition_per_session)) return $this->tuition_per_session;
        return number_format($this->tuition_per_session, 0, ",", ".");
    }



    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher');
    }
    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }
}
