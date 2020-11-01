<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Course\CourseRepositoryInterface;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{

    protected $courseRepository;
    public function __construct(
        CourseRepositoryInterface $courseRepository
        )
    {
        $this->courseRepository = $courseRepository;
    }

    public function getCourseRegisterPage()
    {
        return view('front.course.course-register');
    }

    public function ajaxStore(Request $request)
    {
        return $this->courseRepository->store($request);
    }

    public function getNewClassPage()
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        $recordPerPage = 12;
        $res = $this->courseRepository->teacherCourseRegistrationPagination(0, $recordPerPage);
        $count = $res['count'];
        $courses = $res['data'];

        if ($count % $recordPerPage) {
            $max = floor($count / $recordPerPage) + 1;
        } else {
            $max = floor($count / $recordPerPage);
        }
        return view('front.course.new-class-page', compact('courses'));
    }


}
