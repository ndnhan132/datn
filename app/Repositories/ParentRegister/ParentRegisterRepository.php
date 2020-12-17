<?php

namespace App\Repositories\ParentRegister;

use App\Repositories\BaseRepository;
use App\Models\ParentRegister;
use Illuminate\Support\Facades\Log;

class ParentRegisterRepository extends BaseRepository implements ParentRegisterRepositoryInterface
{
    public function getModel()
    {
        return ParentRegister::class;
    }

    public function pagination($startFrom, $recordPerPage, $is_received, $course_status, $select_subject, $select_course_level, $searchText, $searchCriterion)
    {
        $query = $this->model;

        if ($is_received === 'NO') {
            $query = $query->whereDoesntHave('teacherCourseRegistrations', function($q) {
                return $q->where('registration_status_id', \App\Models\RegistrationStatus::RECEIVED_ID);
            });
        }
        elseif ($is_received === 'YES') {
            $query = $query->whereHas('teacherCourseRegistrations', function($q) {
                return $q->where('registration_status_id', \App\Models\RegistrationStatus::RECEIVED_ID);
            });
        }
        if($course_status === "NEW") {
            $query = $query->where('flag_is_confirmed', false)->where('flag_is_checked',false);
        }
        elseif($course_status === "YES") {
            $query = $query->where('flag_is_confirmed', true);
        }
        elseif($course_status === "NO") {
            $query = $query->where('flag_is_confirmed', false)->where('flag_is_checked',true);
        }

        if($select_subject){
            $query = $query->whereHas('course', function($q) use ($select_subject){
                return $q->where('subject_id', $select_subject);
            });
        }
        if($select_course_level){
            $query = $query->whereHas('course', function($q) use ($select_course_level){
                return $q->where('course_level_id', $select_course_level);
            });
        }

        if($searchText && $searchCriterion) {
            // dd($searchText, $searchCriterion);
            $query = $query->where($searchCriterion, 'like', '%' . $searchText . '%');
        }

        $total = $query->count();
        $data = $query->orderBy('id', 'DESC')
                    ->offset($startFrom)
                    ->limit($recordPerPage)
                    ->get();
        return array(
            'data' => $data,
            'total' => $total
        );
    }

    public function store($request)
    {
        $reg = new ParentRegister();
        $reg->fullname = $request['fullname'];
        $reg->email = $request['email'];
        $reg->phone = $request['phone'];
        $reg->address = $request['address'];
        $reg->time_working = $request['time_working'];
        $reg->tuition_per_session = $request['tuition_per_session'];
        $reg->course_id = $request['select_course'];
        $reg->teacher_id = $request['select_teacher'];

        // if (true) {
        if ($reg->save()) {
            return array(
                'success' => true,
                'record' => $reg,
            );
        } else {
            return array(
                'success' => false,
                'record' => '',
            );
        }
    }
    public function checkCanRegister7day($request)
    {
        $regId = $this->model->where('email', $request['email'])
                            ->orWhere('phone', $request['phone'])->pluck('id');

        $reg = $this->model->where('teacher_id', $request['select_teacher'])
                            ->where('course_id', $request['select_course'])
                            ->whereIn('id', $regId)
                            ->orderBy('created_at', 'DESC')
                            ->first();
        if(!$reg){
            return true;
        }
        $createdAt = strtotime($reg->created_at);
        $diff = time() - $createdAt;
        if($diff > 7 * 24 * 60 * 60){
            return true;
        }
        return false;
    }

    public function checkCanRegisterDuplicateTeacher($request)
    {
        $regId = $this->model->where('email', $request['email'])
                            ->orWhere('phone', $request['phone'])->pluck('id');
        $reg = $this->model->where('course_id', $request['select_course'])
                            ->whereIn('id', $regId)
                            ->where('flag_is_checked', false)
                            ->orderBy('created_at', 'DESC')
                            ->first();
        if(!$reg){
            return true;
        }

        $createdAt = strtotime($reg->created_at);
        $diff = time() - $createdAt;
        if($diff > 7 * 24 * 60 * 60){
            return true;
        }
        return false;
    }

    public function findWithData($parentRegisterId)
    {
        return $this->model->with(['teacher', 'course'])->where('id', $parentRegisterId)->first();
    }
    public function confirm($courseId, $isConfirmed)
    {
        $course = $this->model->find($courseId);
        $course->flag_is_confirmed = $isConfirmed;
        $course->flag_is_checked = true;
        return $course->save();
    }
}
