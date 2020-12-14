<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Course\CourseRepositoryInterface;
use App\Repositories\CourseLevel\CourseLevelRepositoryInterface;
use App\Repositories\Subject\SubjectRepositoryInterface;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
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
        $subjects = $this->subjectRepository->index();
        $courseLevels = $this->courseLevelRepository->index();
        return view('admin.course.index', compact(['courseLevels', 'subjects']));
    }

    public function ajaxGetTableContent(Request $request)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);

        $recordPerPage = 10;
        if(isset($request['record_per_page']) && is_numeric($request['record_per_page']) && $request['record_per_page'] > 0) {
            $recordPerPage = $request['record_per_page'];
        }
        $page = 1;
        if(isset($request['page']) && is_numeric($request['page']) && $request['page'] > 1) {
            $page = $request['page'];
        }
        $startFrom = ($page - 1) * $recordPerPage;

        $is_received = false;
        if(isset($request['is_received']) && in_array($request['is_received'], array('YES', 'NO'))){
            $is_received = strval($request['is_received']);
        }
        $course_status = false;
        if(isset($request['course_status']) && in_array($request['course_status'], array('YES', 'NO', 'NEW'))){
            $course_status = strval($request['course_status']);
        }
        $select_subject = false;
        if(isset($request['select_subject']) && is_numeric($request['select_subject'])){
            $select_subject = strval($request['select_subject']);
        }
        $select_course_level = false;
        if(isset($request['select_course_level']) && is_numeric($request['select_course_level'])){
            $select_course_level = strval($request['select_course_level']);
        }
        $searchText = false;
        if(isset($request['search_text'])){
            $searchText = $request['search_text'];
        }
        $searchCriterion = false;
        if(isset($request['search_criterion'])){
            $searchCriterion = $request['search_criterion'];
        }

        $res = $this->courseRepository->pagination(
                                                        $startFrom
                                                        ,$recordPerPage
                                                        ,$is_received
                                                        ,$course_status
                                                        ,$select_subject
                                                        ,$select_course_level
                                                        ,$searchText
                                                        ,$searchCriterion
                                                    );
        $total = $res['total'];
        $courses = $res['data'];
        if ($total % $recordPerPage) {
            $max = floor($total / $recordPerPage) + 1;
        } else {
            $max = floor($total / $recordPerPage);
        }
        $subjects = $this->subjectRepository->index();
        $courseLevels = $this->courseLevelRepository->index();
        // $totalNewCourse = $this->courseRepository->getTotalNewCourse();
        return view('admin.course.main-table', compact([
                                                        'courses',
                                                        'max',
                                                        'page',
                                                        'startFrom',
                                                        'recordPerPage',
                                                        'total',
                                                        'is_received',
                                                        'course_status',
                                                        'subjects',
                                                        'courseLevels',
                                                        'select_subject',
                                                        'select_course_level',
                                                        // 'totalNewCourse',
                                                        'searchText',
                                                        'searchCriterion'
                                                    ]));
    }

    public function ajaxShow(Request $request, $courseId)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        if($courseId){
            $course = $this->courseRepository->find($courseId);
            $canConfirm = (isset($request['can-confirm']) && $request['can-confirm'] == 'yes') ? true : false;
            if($course) {
                $html = view('admin.course.detail', compact(['course', 'canConfirm']));
                $html = strval($html);
                $html = trim($html);

                return response()->json(array(
                    'success' => true,
                    'data'    => null,
                    'html'    => $html,
                ));
            }
        }

        return response()->json(array(
            'success' => 'false',
            'message' => 'Có lỗi xảy ra!',
        ));
    }

    public function ajaxConfirm(Request $request)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        $courseId = ($request['courseId']) ? $request['courseId'] : '';
        $isConfirmed = (isset($request['isConfirmed'])) ? $request['isConfirmed'] : '';
        if($courseId != '' && in_array($isConfirmed, array('0', '1'))) {
            return response()->json(array(
                'success' => $this->courseRepository->confirm($courseId, $isConfirmed),
                'message' => '',
            ));
        }

        return response()->json(array(
            'success' => 'false',
            'message' => 'Có lỗi xảy ra!'
        ));
    }

    public function ajaxDelete(Request $request) {
        $success = false;
        $message = false;
        if(isset($request['recordId'])) {
            $id = $request['recordId'];
            if($this->courseRepository->destroy($id)) {
                $success = true;
            }
        }
        return response()->json(array(
            'success' => $success,
            'message' => $message,
        ));
    }

    public function ajaxGetCourseByCourselevelAndSubject(Request $request)
    {
        $courseLevelId = $request['courselevel'] ?? '0';
        $subjectId = $request['subject'] ?? '0';
        $course = $this->courseRepository->getByCourseLevelIdAndSubject($courseLevelId, $subjectId);
        $msg = '';
        $success = false;
        if($course) {
            $success = true;
        }else{
            $msg = 'Không tìm thấy lớp này.';
        }
        return response()->json(array(
            'success' => $success,
            'data'    => $course,
            'message' => $msg,
        ));
    }

    public function ajaxUpdateCourse(Request $request)
    {
        $courseId = false;
        $isUpdate = false;
        if(isset($request['course_id'])){
            $courseId = $request['course_id'];
            if(is_numeric($courseId) && $courseId > 0){
                $isUpdate = true;
            }
        }
        if($isUpdate){
            $success = $this->courseRepository->update($courseId, $request);
        }
        else{
            $success = $this->courseRepository->store($request);
        }
        return response()->json(array(
            'success' => $success,
        ));
    }

    public function ajaxGetCourseById(Request $request)
    {
        $courseId = $request['courseid'];
        if($courseId){
            return response()->json(array(
                'success' => true,
                'data' => $this->courseRepository->find($courseId),
            ));
        }
        return response()->json(array(
            'success' => false,
        ));
    }
}
