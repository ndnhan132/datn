<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Course\CourseRepositoryInterface;
use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\Subject\SubjectRepositoryInterface;
use App\Repositories\CourseLevel\CourseLevelRepositoryInterface;
use Illuminate\Support\Facades\Log;
use App\Repositories\Teacher\TeacherRepositoryInterface;

class PageController extends Controller
{
    protected $courseRepository;
    protected $subjectRepository;
    protected $courseLevelRepository;
    protected $postRepository;
    protected $teacherRepository;

    public function __construct(
        CourseRepositoryInterface $courseRepository,
        SubjectRepositoryInterface $subjectRepository,
        TeacherRepositoryInterface $teacherRepository,
        PostRepositoryInterface $postRepository,
        CourseLevelRepositoryInterface $courseLevelRepository
        )
    {
        $this->courseRepository = $courseRepository;
        $this->subjectRepository = $subjectRepository;
        $this->postRepository = $postRepository;
        $this->courseLevelRepository = $courseLevelRepository;
        $this->teacherRepository = $teacherRepository;
    }
    public function index()
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        $courses = $this->courseRepository->getHomeCourse(7);
        // $teachers = $this->teacherRepository->getHomeTeacher(20);
        return view('front.home.index', compact(['courses']));
    }
    public function ajaxLoadListTeacherSlider()
    {
        $teachers = $this->teacherRepository->getHomeTeacher(20);
        return view('front.home.ajax-list-teacher', compact(['teachers']));
    }
    public function ajaxLoadReferenceTuition()
    {
        $subjects     = $this->subjectRepository->index();
        $courseLevels = $this->courseLevelRepository->index();
        $courses = $this->courseRepository->index();
        return view('front.home.ajax-reference-tuition', compact(['courseLevels', 'subjects', 'courses']));
    }
    public function ajaxLoadReferenceTuitionWithoutReadmore()
    {
        $subjects     = $this->subjectRepository->index();
        $courseLevels = $this->courseLevelRepository->index();
        $courses = $this->courseRepository->index();
        return view('front.reference-tuition.ajax-reference-tuition', compact(['courseLevels', 'subjects', 'courses']));
    }
    public function getReferenceTuitionPage()
    {
        return view('front.reference-tuition.index');
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

    public function getForTeacherPage()
    {
        return view('front.teacher.for-teacher');
    }

    public function getForParentPage()
    {
        return view('front.course.for-parent');
    }

    public function getListNews()
    {
        $recordPerPage = 6;
        $page = 1;
        $startFrom = 0;
        $res = $this->postRepository->getNewsWithPagination($startFrom, $recordPerPage);
        $total = $res['total'];
        $articles = $res['data'];

        if ($total % $recordPerPage) {
            $max = floor($total / $recordPerPage) + 1;
        } else {
            $max = floor($total / $recordPerPage);
        }
        return view('front.articles.list-articles', compact(['articles', 'total', 'max', 'page', 'recordPerPage']));
    }

    public function ajaxGetListNews(Request $request)
    {
        $recordPerPage = 6;
        if(isset($request['recordPerPage'])) {
            $recordPerPage = $request['record-per-page'];
        }
        $page = 1;
        if(isset($request['page'])) {
            $page = $request['page'];
        }
        $startFrom = ($page - 1) * $recordPerPage;
        $res = $this->postRepository->getNewsWithPagination($startFrom, $recordPerPage);
        $total = $res['total'];
        $articles = $res['data'];

        if ($total % $recordPerPage) {
            $max = floor($total / $recordPerPage) + 1;
        } else {
            $max = floor($total / $recordPerPage);
        }
        return view('front.articles.lists', compact(['articles', 'total', 'max', 'page', 'recordPerPage']));
    }

    public function readPost($slug, Request $request)
    {
        if($slug){
            $post = $this->postRepository->findNewsBySlug($slug);
            if($post){
                return view('front.articles.read', compact('post'));
            }
        }
        return redirect()->back();
    }
}
