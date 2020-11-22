<?php

namespace App\Repositories\Course;

use App\Repositories\BaseRepository;
use Illuminate\Support\Str;
use App\Models\Course;

class CourseRepository extends BaseRepository implements CourseRepositoryInterface
{
    public function getModel()
    {
        return Course::class;
    }

    public function getHomeCourse($itemPerPage = 5)
    {
        return $this->model->where("flag_is_confirmed", true)
                           ->orderBy('created_at', 'asc')
                           ->limit($itemPerPage)
                           ->offset(0)
                           ->get();
    }

    public function pagination($startFrom, $recordPerPage)
    {
        return $this->model->orderBy('id', 'DESC')
                    ->offset($startFrom)
                    ->limit($recordPerPage)
                    ->get();
    }

    public function confirm($courseId, $isConfirmed)
    {
        $course = $this->model->find($courseId);
        $course->flag_is_confirmed = $isConfirmed;
        return $course->save();
    }

    public function teacherCourseRegistrationPagination($startFrom, $recordPerPage)
    {
        $data = $this->model->where('flag_is_confirmed', true)
                    ->orderBy('id', 'DESC')
                    ->offset($startFrom)
                    ->limit($recordPerPage)
                    ->get();
        $count = $this->model->where('flag_is_confirmed', true)->count();

        return array(
            'data' => $data,
            'count' => $count
        );
    }

    public function store($request)
    {
        $course = new Course();

        $course->fullname = $request['fullname'];
        $course->address = $request['address'];
        $course->phone = $request['phone'];
        $course->email = $request['email'];

        $course->course_level_id = $request['course_level'] ?? '';
        $course->other_course_level = $request['course_other_level'] ?? '';
        $course->subject_id = $request['subject'];
        $course->other_subject = $request['other_subject'] ?? '';
        $course->num_of_student = $request['num_of_student'];
        $course->tuition_per_month = $request['tuition_per_month'];
        $course->session_per_week = $request['session_per_week'];
        $course->time_per_session = $request['time_per_session'];
        $course->time_working = $request['time_working'] ?? '';

        $course->teacher_level_id = $request['teacher_level'];
        $course->other_teacher_level = $request['other_teacher_level'] ?? '';
        $gender = 'BOTH';
        if(isset($request['teacher_gender'])){
            if($request['teacher_gender'] == 'MALE') $gender = 'MALE';
            if($request['teacher_gender'] == 'FEMALE') $gender = 'FEMALE';
        }
        $course->teacher_gender = $gender;
        $course->other_requirement = $request['other_requirement'];

        $course->title = time();
        $course->slug = time();
        $course->save();
        $course = $this->model->find($course->id);
        $title = 'tìm';
        if ($gender == 'Male') {
            $title .= ' nam';
        }elseif ($gender == 'Female') {
            $title .= ' nữ';
        }
        $title .= ' gia sư dạy';
        if($course->subject){
            $title .= ' ' . $course->subject->display_name;
        } else {
            $title .= ' ' . $course->other_subject;
        }
        if($course->courseLevel){
            $title .= ' ' . $course->courseLevel->display_name;
        }else{
            $title .= ' ' . $course->other_course_level;
        }
        $course->title = $title;
        $course->slug = Str::slug($title, '-') . '-' . time();
        if($course->save()){
            return $course;
        }else {
            return false;
        }
    }

    public function getNewClassesWithPagination($startFrom, $recordPerPage)
    {
        // $data = $this->model->orderBy('id', 'DESC')
        //                    ->where('flag_is_checked', true)
        //                    ->where('flag_is_confirmed', true)
        //                    ->get();
        // $count = $this->model->where('flag_is_checked', true)
        //                     ->where('flag_is_confirmed', true)
        //                     ->count();
        // return array(
        //     'data' => $data,
        //     'count' => $count
        // );
    }

    public function findBySlug($slug)
    {
        return $this->model->where('slug', $slug)->first();
    }

    public function getWithPagination($startFrom, $recordPerPage, $type, $confirmedRequired)
    {
        $query = $this->model;
        if($confirmedRequired) {
            $query = $query->where('flag_is_confirmed', true);
        }
        if($type == 'ALL') {
            $query = $query;
        }
        elseif ($type == 'NOT_RECEIVED'){
            $query = $query->whereDoesntHave('teacherCourseRegistrations', function($q) {
                return $q->where('registration_status_id', \App\Models\RegistrationStatus::RECEIVED_ID);
            });
        }

        $count = $query->count();
        $data = $query->orderBy('id', 'DESC')
                      ->offset($startFrom)
                      ->limit($recordPerPage)
                      ->get();

        return array(
        'data' => $data,
        'count' => $count
        );
    }

    public function findWithData($courseId)
    {
        return $this->model->with(['subject', 'teacherLevel', 'courseLevel'])->where('id', $courseId)->first();
    }

}
