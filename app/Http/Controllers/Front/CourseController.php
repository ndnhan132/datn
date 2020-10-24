<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Course\CourseRepositoryInterface;

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
}
