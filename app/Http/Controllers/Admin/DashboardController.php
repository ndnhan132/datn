<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\TeacherCourseRegistration\TeacherCourseRegistrationRepositoryInterface;
use App\Repositories\Course\CourseRepositoryInterface;
use App\Repositories\RegistrationStatus\RegistrationStatusRepositoryInterface;
use App\Repositories\Teacher\TeacherRepositoryInterface;
use App\Repositories\TeacherLevel\TeacherLevelRepositoryInterface;
use Illuminate\Support\Facades\Log;
use App\Repositories\Subject\SubjectRepositoryInterface;
use App\Repositories\CourseLevel\CourseLevelRepositoryInterface;
use App\Repositories\ParentRegister\ParentRegisterRepositoryInterface;

class DashboardController extends Controller
{
    protected $teacherCourseRegistrationRepository;
    protected $courseRepository;
    protected $registrationStatusRepository;
    protected $teacherRepository;
    protected $teacherLevelRepository;
    protected $subjectRepository;
    protected $courseLevelRepository;
    protected $parentRegisterRepository;

    public function __construct(
        TeacherCourseRegistrationRepositoryInterface $teacherCourseRegistrationRepository,
        CourseRepositoryInterface $courseRepository,
        RegistrationStatusRepositoryInterface $registrationStatusRepository,
        TeacherLevelRepositoryInterface $teacherLevelRepository,
        SubjectRepositoryInterface $subjectRepository,
        TeacherRepositoryInterface $teacherRepository,
        CourseLevelRepositoryInterface $courseLevelRepository,
        ParentRegisterRepositoryInterface $parentRegisterRepository
        )
    {
        $this->teacherCourseRegistrationRepository = $teacherCourseRegistrationRepository;
        $this->courseRepository = $courseRepository;
        $this->registrationStatusRepository = $registrationStatusRepository;
        $this->teacherRepository = $teacherRepository;
        $this->teacherLevelRepository = $teacherLevelRepository;
        $this->subjectRepository = $subjectRepository;
        $this->courseLevelRepository = $courseLevelRepository;
        $this->parentRegisterRepository = $parentRegisterRepository;
    }

    public function index(  )
    {
        if( $_SERVER['REQUEST_URI'] == parse_url(route('admin.dashboard.index'), PHP_URL_PATH)) {
            return view('admin.dashboard.index');
        } else {
            return redirect()->route('admin.dashboard.index');
        }
    }

    public function ajaxGetDashboardCount()
    {
        $teachers = count($this->teacherRepository->index()->where('teacher_account_status_id', \App\Models\TeacherAccountStatus::CONFIRMED_ID));
        $courses = count($this->courseRepository->index());
        $parent_reg = count($this->parentRegisterRepository->index()->where('flag_is_confirmed', true));
        $teacher_reg = count($this->teacherCourseRegistrationRepository->index()->where('registration_status_id', \App\Models\RegistrationStatus::ELIGIBLE_ID));
        return response()->json(array(
            'success' => true,
            'count' => array(
                'teachers' => $teachers,
                'courses' => $courses,
                'teacher_reg' => $teacher_reg,
                'parent_reg' => $parent_reg,
            ),
        ));
    }
}
