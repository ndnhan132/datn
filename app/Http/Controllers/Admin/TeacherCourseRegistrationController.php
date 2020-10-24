<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\TeacherCourseRegistration\TeacherCourseRegistrationRepositoryInterface;
use App\Repositories\Course\CourseRepositoryInterface;
use Illuminate\Support\Facades\Log;

class TeacherCourseRegistrationController extends Controller
{
    protected $teacherCourseRegistrationRepository;
    protected $courseRepository;

    public function __construct(
        TeacherCourseRegistrationRepositoryInterface $teacherCourseRegistrationRepository,
        CourseRepositoryInterface $courseRepository
        )
    {
        $this->teacherCourseRegistrationRepository = $teacherCourseRegistrationRepository;
        $this->courseRepository = $courseRepository;

    }

    public function index()
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        return view('admin.teacher-course-registration.index');
    }

    public function ajaxGetTableContent(Request $request)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        isset($request['recordPerPage']) ? $recordPerPage = $request['record-per-page'] : $recordPerPage = 10;
        isset($request['page']) ? ($page = $request['page']) : ($page = 1);
        $startFrom = ($page - 1) * $recordPerPage;
        $res = $this->courseRepository->teacherCourseRegistrationPagination($startFrom, $recordPerPage);
        $teacherCourseRegistrations = $res['data'];
        $count = $res['count'];
        if ($count % $recordPerPage) {
            $max = floor($count / $recordPerPage) + 1;
        } else {
            $max = floor($count / $recordPerPage);
        }

        return view('admin.teacher-course-registration.main-table', compact(['teacherCourseRegistrations', 'max', 'page']));
    }

    public function ajaxGetTeacherRegistration(Request $request, $courseId)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        $courseRegistrations = $this->courseRepository->find($courseId);
        return view('admin.teacher-course-registration.registration-table', compact('courseRegistrations'));
    }
}
