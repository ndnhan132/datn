<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Course\CourseRepositoryInterface;
use App\Repositories\Subject\SubjectRepositoryInterface;
use App\Repositories\TeacherLevel\TeacherLevelRepositoryInterface;
use App\Repositories\CourseLevel\CourseLevelRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Validator;

class CourseController extends Controller
{

    protected $courseRepository;
    protected $subjectRepository;
    protected $courseLevelRepository;
    protected $teacherLevelRepository;
    public function __construct(
        CourseRepositoryInterface $courseRepository,
        SubjectRepositoryInterface $subjectRepository,
        TeacherLevelRepositoryInterface $teacherLevelRepository,
        CourseLevelRepositoryInterface $courseLevelRepository
        )
    {
        $this->courseRepository = $courseRepository;
        $this->subjectRepository = $subjectRepository;
        $this->courseLevelRepository = $courseLevelRepository;
        $this->teacherLevelRepository = $teacherLevelRepository;
    }

    public function getCourseRegisterPage()
    {
        $subjects      = $this->subjectRepository->index();
        $courseLevels  = $this->courseLevelRepository->index();
        $teacherLevels = $this->teacherLevelRepository->index();
        return view('front.course.course-register', compact(['subjects', 'courseLevels', 'teacherLevels']));
    }

    public function ajaxStore(Request $request)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        $validator = Validator::make(
            $request->all(),
            [
                // 'current_password' => 'required',
                // 'password' => 'required|confirmed',
            ],
            [
                'required' => ':attribute không được để trống',
                'confirmed' => ':attribute không khớp nhau',
            ],
            [
                'current_password' => 'Mật khẩu hiện tại',
                'password' => 'Mật khẩu mới',
            ]
        );
        $success = false;
        $message = '';
        $redirect = '';
        if ($validator->passes()) {
            $course = $this->courseRepository->store($request);
            if($course){
                $success = true;
                $redirect = route('front.teacherRegisterCourse', $course->slug);
            }
        }else{
            $message = $validator->errors()->all();
        }

        return response()->json(array(
            'success' => $success,
            'message' => $message,
            'redirect'     => $redirect,
        ));
    }

    public function getNotReceivedClassPage()
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        $page = 1;
        $startFrom = 0;
        $recordPerPage = 12;
        $confirmedRequired = true;
        $type = 'NOT_RECEIVED';
        $res     = $this->courseRepository->getWithPagination($startFrom, $recordPerPage, $type, $confirmedRequired);
        $total   = $res['total'];
        $courses = $res['data'];

        if ($total % $recordPerPage) {
            $max = floor($total / $recordPerPage) + 1;
        } else {
            $max = floor($total / $recordPerPage);
        }

        return view('front.course.list-class-page', compact(['courses', 'max', 'page', 'type']));
    }

    public function getAllClassPage(Request $request)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        $page = 1;
        $startFrom = 0;
        $recordPerPage = 12;
        $confirmedRequired = true;
        $type    = 'ALL';
        $res     = $this->courseRepository->getWithPagination($startFrom, $recordPerPage,  $type, $confirmedRequired, false, false, false);
        $total   = $res['total'];
        $courses = $res['data'];

        if ($total % $recordPerPage) {
            $max = floor($total / $recordPerPage) + 1;
        } else {
            $max = floor($total / $recordPerPage);
        }
        $teacherLevels = $this->teacherLevelRepository->index();
        $courseLevels = $this->courseLevelRepository->index();
        $subjects = $this->subjectRepository->index();

        return view('front.course.list-class-page', compact([
                                                                'courses',
                                                                'max',
                                                                'page',
                                                                'type',
                                                                'total',
                                                                'teacherLevels',
                                                                'courseLevels',
                                                                'subjects'
                                                            ]));
    }

    public function ajaxGetListClass(Request $request)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        isset($request['recordPerPage']) ? $recordPerPage = $request['record-per-page'] : $recordPerPage = 12;
        isset($request['page']) ? ($page = $request['page']) : ($page = 1);
        $startFrom = ($page - 1) * $recordPerPage;
        $confirmedRequired = true;
        isset($request['type']) ? ($type = $request['type']) : ($type = 'ALL');

        $select_teacher_level = false;
        if(isset($request['teacher_level'])) {
            if(is_numeric($request['teacher_level']) && $request['teacher_level'] > 0){
                $select_teacher_level = $request['teacher_level'];
            }
        }
        $select_course_level = false;
        if(isset($request['course_level'])) {
            if(is_numeric($request['course_level']) && $request['course_level'] > 0){
                $select_course_level = $request['course_level'];
            }
        }
        $select_subject = false;
        if(isset($request['subject'])) {
            if(is_numeric($request['subject']) && $request['subject'] > 0){
                $select_subject = $request['subject'];
            }
        }

        $res     = $this->courseRepository->getWithPagination(
                                                                $startFrom,
                                                                $recordPerPage,
                                                                $type,
                                                                $confirmedRequired,
                                                                $select_teacher_level,
                                                                $select_course_level,
                                                                $select_subject
                                                            );
        $total   = $res['total'];
        $courses = $res['data'];
        if ($total % $recordPerPage) {
            $max = floor($total / $recordPerPage) + 1;
        } else {
            $max = floor($total / $recordPerPage);
        }

        $html = view('front.course.list-class-table', compact([
                                                                'courses',
                                                                'max',
                                                                'page',
                                                                'total',
                                                            ]));
        $html = strval($html);
        $html = trim($html);

        return response()->json(array(
            'success' => true,
            'html'    => $html,
        ));
    }

}
