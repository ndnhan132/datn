<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Course\CourseRepositoryInterface;
use App\Repositories\Subject\SubjectRepositoryInterface;
use App\Repositories\CourseLevel\CourseLevelRepositoryInterface;
use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    protected $courseRepository;
    protected $subjectRepository;
    protected $courseLevelRepository;

    public function __construct(
        CourseRepositoryInterface $courseRepository,
        SubjectRepositoryInterface $subjectRepository,
        CourseLevelRepositoryInterface $courseLevelRepository
        )
    {
        $this->courseRepository = $courseRepository;
        $this->subjectRepository = $subjectRepository;
        $this->courseLevelRepository = $courseLevelRepository;
    }
    public function index()
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        $courses = $this->courseRepository->getHomeCourse(5);
        // $subjects = $this->subjectRepository->index();
        // $courseLevels = $this->courseLevelRepository->index();
        // \Debugbar::debug($courses);
        // \Debugbar::debug($subjects);
        // \Debugbar::debug($courseLevels);
        return view('front.home.index', compact(['courses']));
    }

    public function ajaxLoadAsideData(Request $request)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        $subjects     = $this->subjectRepository->index();
        $courseLevels = $this->courseLevelRepository->index();
        $htmlTeacherByCourseLevel = view('front.layouts.asidebar.teacher-by-courselevel', compact('courseLevels'));
        $htmlTeacherByCourseLevel = strval($htmlTeacherByCourseLevel);
        $htmlTeacherByCourseLevel = trim($htmlTeacherByCourseLevel);
        $htmlTeacherBySubject     = view('front.layouts.asidebar.teacher-by-subject', compact(['subjects']));
        $htmlTeacherBySubject     = strval($htmlTeacherBySubject);
        $htmlTeacherBySubject     = trim($htmlTeacherBySubject);
        $htmlSupport     = view('front.layouts.asidebar.support');
        $htmlSupport     = strval($htmlSupport);
        $htmlSupport     = trim($htmlSupport);


        return response()->json(array(
            'success' => true,
            'data'    => null,
            'html'    => array(
                'teacherByCourseLevel' => $htmlTeacherByCourseLevel,
                'teacherBySubject'     => $htmlTeacherBySubject,
                'support'     => $htmlSupport,
            )
        ));
    }
}
