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

class TeacherCourseRegistrationController extends Controller
{
    protected $teacherCourseRegistrationRepository;
    protected $courseRepository;
    protected $registrationStatusRepository;
    protected $teacherRepository;
    protected $teacherLevelRepository;

    public function __construct(
        TeacherCourseRegistrationRepositoryInterface $teacherCourseRegistrationRepository,
        CourseRepositoryInterface $courseRepository,
        RegistrationStatusRepositoryInterface $registrationStatusRepository,
        TeacherLevelRepositoryInterface $teacherLevelRepository,
        TeacherRepositoryInterface $teacherRepository
        )
    {
        $this->teacherCourseRegistrationRepository = $teacherCourseRegistrationRepository;
        $this->courseRepository = $courseRepository;
        $this->registrationStatusRepository = $registrationStatusRepository;
        $this->teacherRepository = $teacherRepository;
        $this->teacherLevelRepository = $teacherLevelRepository;

    }

    public function index()
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        return view('admin.teacher-course-registration.index');
    }

    public function ajaxGetTableContent(Request $request)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        $recordPerPage = 10;
        if(isset($request['record_per_page'])&& is_numeric($request['record_per_page'])){
            $recordPerPage = $request['record_per_page'];
        }
        $page = 1;
        if(isset($request['page']) && is_numeric($request['page']) && $request['page'] > 1) {
            $page = $request['page'];
        }
        $startFrom = ($page - 1) * $recordPerPage;
        $select_registration_status = false;
        if(isset($request['select_registration_status']) && is_numeric($request['select_registration_status'])){
            $select_registration_status = $request['select_registration_status'];
        }
        $searchText = false;
        if(isset($request['search_text']) && strlen($request['search_text']) > 0){
            $searchText = $request['search_text'];
        }
        $searchCriterion = false;
        if(isset($request['search_criterion'])){
            $searchCriterion = $request['search_criterion'];
        }

        $res = $this->teacherCourseRegistrationRepository->pagination(
                                                                        $startFrom,
                                                                        $recordPerPage,
                                                                        $select_registration_status,
                                                                        $searchText,
                                                                        $searchCriterion
                                                                    );
        $teacherCourseRegistrations = $res['data'];
        $total = $res['total'];
        if ($total % $recordPerPage) {
            $max = floor($total / $recordPerPage) + 1;
        } else {
            $max = floor($total / $recordPerPage);
        }
        $registrationStatuses = $this->registrationStatusRepository->index();
        $totalNewRegistration = $this->teacherCourseRegistrationRepository->getTotalNewRegistration();
        return view('admin.teacher-course-registration.main-table', compact([
                                                                            'teacherCourseRegistrations',
                                                                            'max',
                                                                            'page',
                                                                            'startFrom',
                                                                            'recordPerPage',
                                                                            'total',
                                                                            'registrationStatuses',
                                                                            'select_registration_status',
                                                                            'totalNewRegistration',
                                                                            'searchText',
                                                                            'searchCriterion'
                                                                        ]));
    }

    public function ajaxGetTeacherRegistration(Request $request, $courseId)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        $courseRegistrations = $this->courseRepository->find($courseId);
        return view('admin.teacher-course-registration.registration-table', compact('courseRegistrations'));
    }
    public function ajaxGetCompare(Request $request, $registrationId)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        $registration = $this->teacherCourseRegistrationRepository->find($registrationId);
        if($registration){
            $html = view('admin.teacher-course-registration.compare', compact('registration'));
            $html = strval($html);
            $html = trim($html);
            return response()->json(array(
                'success' => 'true',
                'data'    => null,
                'html'    => $html,
            ));
        }
        return response()->json(array('success' => 'false'));
    }

    public function ajaxConfirmStatus(Request $request)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        if(isset($request['registrationId'], $request['registrationStatus'])){
            $registrationId = $request['registrationId'];
            $registrationStatus = $request['registrationStatus'];
            $status = $this->registrationStatusRepository->findByName($registrationStatus);
            $registration = $this->teacherCourseRegistrationRepository->find($registrationId);
            // if($registration->course->received() && !$registration->isReceived()) {
            if($registration->canChangeStatus()) {
                $statusId = $status->id;
                if($statusId){
                    $res = $this->teacherCourseRegistrationRepository->confirmStatus($registrationId, $statusId);
                    return response()->json(array('success' => boolval($res)));
                }
            }else{
                return response()->json(array(
                    'success' => false,
                    'message' => 'Khoá học này đã có người nhận. Không thể thay đổi trạng thái!',
                ));
            }
        }
        return response()->json(array(
            'success' => false,
            'message' => 'Có lỗi xảy ra',
        ));
    }
}
