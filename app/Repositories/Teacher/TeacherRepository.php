<?php

namespace App\Repositories\Teacher;

use App\Repositories\BaseRepository;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\TeacherAccountStatus;

class TeacherRepository extends BaseRepository implements TeacherRepositoryInterface
{
    public function getModel()
    {
        return Teacher::class;
    }

    public function store($request)
    {
        $teacher = new Teacher();
        $teacher->name = $request['name'] ?? '';
        $teacher->email = $request['email'];
        $teacher->password = bcrypt($request['password']);
        $teacher->last_modified = time();

        if($teacher->save()){
            return $teacher;
        }
        return false;
    }

    public function pagination($startFrom, $recordPerPage, $teacherAccountStatus, $teacherLevelId, $searchText, $searchCriterion)
    {
        $query = $this->model;
        if($teacherAccountStatus) {
            if($teacherAccountStatus == 'NEW') {
                $query = $query->whereNull('teacher_account_status_id');
            }
            elseif(in_array($teacherAccountStatus, array(TeacherAccountStatus::CONFIRMED_ID, TeacherAccountStatus::INELIGIBLE_ID, TeacherAccountStatus::REQUEST_VERIFICATION_ID))){
                $query = $query->where('teacher_account_status_id', $teacherAccountStatus);
            }
        }
        if($teacherLevelId && is_numeric($teacherLevelId)) {
            $query = $query->where('teacher_level_id', $teacherLevelId);
        }
        if($searchText && $searchCriterion) {
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
    // public function markAsChecked($teacher)
    // {
    //     $teacher->find($teacher)->flag_is_checked = true;
    //     return $teacher->save();
    // }

    public function confirm($teacherId, $isActive)
    {
        $teacher = $this->model->find($teacherId);
        $teacher->flag_is_teacher = $isActive;
        $teacher->flag_is_checked = true;
        return $teacher->save();
    }

    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function updateGeneral($request)
    {
        $teacher = $this->model->find(Auth::guard('teacher')->user()->id);
        $teacher->name = $request->input('name');
        $teacher->address = $request->input('address');
        $teacher->phone = $request->input('phone');
        $teacher->is_male = $request->input('is_male');
        $teacher->description = $request->input('description');
        $teacher->identity_card = $request->input('identity_card');
        $teacher->year_of_birth = $request->input('year_of_birth');
        $teacher->last_modified = time();
        return $teacher->save();
    }

    public function updatePassword($request)
    {
        $teacher = $this->model->find(Auth::guard('teacher')->user()->id);
        $teacher->password = bcrypt($request->input('password'));
        return $teacher->save();
    }

    public function updateEducation($request)
    {
        $teacher = $this->model->find(Auth::guard('teacher')->user()->id);
        $teacher->university = $request->input('university');
        $teacher->speciality = $request->input('speciality');
        $teacher->teacher_level_id = $request->input('teacher_level_id');
        $teacher->reference_tuition = $request->input('reference_tuition');
        $rs = $teacher->save();
        if($request['course_level']) {
            $teacher->courseLevels()->sync($request['course_level']);
        }
        if($request['subject']) {
            $teacher->subjects()->sync($request['subject']);
        }
        return $rs;
    }
    public function verifyEmail($id)
    {
        $teacher = $this->model->find($id);
        $teacher->email_verified_at = now();
        return $teacher->save();
    }
    public function sendRequestConfirmation($teacherId)
    {
        $teacher = $this->model->find($teacherId);
        $teacher->request_confirmation_at = time();
        $teacher->teacher_account_status_id = \App\Models\TeacherAccountStatus::REQUEST_VERIFICATION_ID;
        return $teacher->save();
    }

    public function getFrontListWithPagination($startFrom, $recordPerPage, $teacherLevelId = false, $gender = 'BOTH', $courseLevelId = false, $subjectId = false)
    {
        $query = $this->model->where('teacher_account_status_id',\App\Models\TeacherAccountStatus::CONFIRMED_ID);
        if($teacherLevelId) {
            $query = $query->where('teacher_level_id', $teacherLevelId);
        }
        if($gender == 'MALE'){
            $query = $query->where('is_male', true);
        }
        elseif($gender == 'FEMALE') {
            $query = $query->where('is_male', false);
        }
        if($courseLevelId) {
            $query = $query->whereHas('courseLevels', function($q) use ($courseLevelId){
                return $q->where('course_level_id', $courseLevelId);
            });
        }
        if($subjectId) {
            $query = $query->whereHas('subjects', function($q) use ($subjectId){
                return $q->where('subject_id', $subjectId);
            });
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
    public function getHomeTeacher($num)
    {
        return $this->model->where('teacher_account_status_id', \App\Models\TeacherAccountStatus::CONFIRMED_ID)
        ->orderBy('created_at', 'asc')
        ->limit($num)
        ->offset(0)
        ->get();
    }
}
