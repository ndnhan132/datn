<?php

namespace App\Repositories\Course;

use App\Repositories\BaseRepository;
use App\Models\Course;

class CourseRepository extends BaseRepository implements CourseRepositoryInterface
{
    public function getModel()
    {
        return Course::class;
    }

    public function getHomeCourse($itemPerPage = 5)
    {
        return $this->model->orderBy('created_at', 'asc')
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
        $course->code = rand(11111, 99999);
        $course->subject_id = rand(1,5);
        $course->course_level_id = rand(1,5);
        $course->fullname = 'test_' . rand();
        $course->address = 'test_' . rand();
        $course->phone = 'test_' . rand();
        $course->email = 'test_' . rand() . "@gmail.com";
        $course->time_working = 'T2 - T7';
        $course->session_per_week = rand(2, 7);
        $course->time_per_session = '60';
        $course->num_of_student = rand(1,3);
        $course->tuition_per_month = rand(1000, 9999) . '000';
        $course->other_requirement = 'lorem ipsum dolor sit amet, consectetur adip';
        return $course->save();
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
}
