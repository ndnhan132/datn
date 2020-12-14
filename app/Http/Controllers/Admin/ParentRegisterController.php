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

class ParentRegisterController extends Controller
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


    public function index()
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        return view('admin.parent-register.index');
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
        if(!$searchCriterion){
            $searchText = '';
        }

        $res = $this->parentRegisterRepository->pagination(
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
        $parentRegisters = $res['data'];
        if ($total % $recordPerPage) {
            $max = floor($total / $recordPerPage) + 1;
        } else {
            $max = floor($total / $recordPerPage);
        }
        $subjects = $this->subjectRepository->index();
        $courseLevels = $this->courseLevelRepository->index();
        return view('admin.parent-register.main-table', compact([
                                                        'parentRegisters',
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
    public function ajaxShow(Request $request, $presentRegisterId)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        if($presentRegisterId){
            $parentRegister = $this->parentRegisterRepository->find($presentRegisterId);
            if($parentRegister) {
                $html = view('admin.parent-register.detail', compact(['parentRegister']));
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

    public function ajaxDelete(Request $request) {
        $success = false;
        $message = false;
        if(isset($request['recordId'])) {
            $id = $request['recordId'];
            if($this->parentRegisterRepository->destroy($id)) {
                $success = true;
            }
        }
        return response()->json(array(
            'success' => $success,
            'message' => $message,
        ));
    }

    public function ajaxConfirm(Request $request)
    {
        $courseId = ($request['courseId']) ? $request['courseId'] : '';
        $isConfirmed = (isset($request['isConfirmed'])) ? $request['isConfirmed'] : '';
        if($courseId != '' && in_array($isConfirmed, array('0', '1'))) {
            return response()->json(array(
                'success' => $this->parentRegisterRepository->confirm($courseId, $isConfirmed),
                'message' => '',
            ));
        }

        return response()->json(array(
            'success' => 'false',
            'message' => 'Có lỗi xảy ra!'
        ));
    }

}
