<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\TeacherCourseRegistration\TeacherCourseRegistrationRepositoryInterface;
use App\Repositories\Course\CourseRepositoryInterface;
use App\Repositories\RegistrationStatus\RegistrationStatusRepositoryInterface;
use Illuminate\Support\Facades\Log;

class TeacherCourseRegistrationController extends Controller
{
    protected $teacherCourseRegistrationRepository;
    protected $courseRepository;
    protected $registrationStatusRepository;

    public function __construct(
        TeacherCourseRegistrationRepositoryInterface $teacherCourseRegistrationRepository,
        CourseRepositoryInterface $courseRepository,
        RegistrationStatusRepositoryInterface $registrationStatusRepository
        )
    {
        $this->teacherCourseRegistrationRepository = $teacherCourseRegistrationRepository;
        $this->courseRepository = $courseRepository;
        $this->registrationStatusRepository = $registrationStatusRepository;

    }

    public function getRegisterPage(Request $request, $slug)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        $course = $this->courseRepository->findBySlug($slug);
        return view('front.teacher-course-registration.register-page', compact('course'));
    }

    public function ajaxLoadTeacherCourseRegistrationBox(Request $request, $courseId)
    {
        return view('front.teacher-course-registration.registration-box', compact('courseId'));
    }

    public function ajaxTeacherRegisterCourse(Request $request)
    {
        $success = false;
        $courseId = $request->input('courseId') ?? '';
        if($courseId){
            $success = $this->teacherCourseRegistrationRepository->teacherRegisterCourse($courseId);
        }
        return response()->json(array(
            'success' => $success
        ));
    }

    public function ajaxReloadRegisterPage(Request $request, $slug)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        $course = $this->courseRepository->findBySlug($slug);
        return view('front.teacher-course-registration.teacher-register-course-content', compact('course'));
    }
}
