<?php

namespace App\Repositories\TeacherCourseRegistration;

use App\Repositories\BaseRepository;
use App\Models\TeacherCourseRegistration;
use Illuminate\Support\Facades\Auth;

class TeacherCourseRegistrationRepository extends BaseRepository implements TeacherCourseRegistrationRepositoryInterface
{
    public function getModel()
    {
        return TeacherCourseRegistration::class;
    }

    public function getByCourseId($courseId)
    {
        // return $this->model->where('course_id', $courseId);
    }
    public function confirmStatus($registrationId, $statusId)
    {
        $registration = $this->model->find($registrationId);
        if($registration){
            $registration->registration_status_id = $statusId;
            return $registration->save();
        }
        return false;
    }

    public function teacherRegisterCourse($courseId)
    {
        if(Auth::guard('teacher')->check()) {
            $teacherId = Auth::guard('teacher')->user()->id;
            $tmp = $this->model->where('teacher_id', $teacherId)->where('course_id', $courseId)->first();
            if($tmp) {
                return false;
            }
            $registration = new TeacherCourseRegistration();
            $registration->teacher_id = $teacherId;
            $registration->course_id = $courseId;
            // $registration->is_teacher_registered = true;
            $registration->registration_status_id = 1;
            return $registration->save() ? true : false;
        }
        return false;
    }
    public function deleteRegistration($courseId, $teacherId)
    {
        $regis = $this->model->where([
            ['course_id', '=', $courseId],
            ['teacher_id', '=', $teacherId]
        ])->first();
        return $regis->delete();
    }
    public function getMyRegistration($teacherId)
    {
        return $this->model->where('teacher_id', '=', $teacherId)->orderBy('id', 'DESC')->get();
    }

    public function pagination($startFrom, $recordPerPage, $select_registration_status, $searchText, $searchCriterion)
    {
        $query = $this->model;

        if($select_registration_status) {
            $query = $query->where('registration_status_id', $select_registration_status);
        }

        if($searchText && $searchCriterion) {
            $relationship = '';
            $field = '';
            switch ($searchCriterion) {
                case 'COURSE_FULLNAME':
                    $relationship = 'course';
                    $field = 'fullname';
                    break;
                case 'COURSE_EMAIL':
                    $relationship = 'course';
                    $field = 'email';
                    break;
                case 'COURSE_PHONE':
                    $relationship = 'course';
                    $field = 'phone';
                    break;
                case 'COURSE_ADDRESS':
                    $relationship = 'course';
                    $field = 'address';
                    break;
                case 'TEACHER_FULLNAME':
                    $relationship = 'teacher';
                    $field = 'name';
                    break;
                case 'TEACHER_EMAIL':
                    $relationship = 'teacher';
                    $field = 'email';
                    break;
                case 'TEACHER_PHONE':
                    $relationship = 'teacher';
                    $field = 'phone';
                    break;

            }
            $query = $query->whereHas($relationship, function($q) use($searchText, $field) {
                return $q->where($field, 'like', '%' . $searchText . '%');
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
    public function getTotalNewRegistration()
    {
        return $this->model->where('registration_status_id', \App\Models\RegistrationStatus::PENDING_ID)->count();
    }
}
