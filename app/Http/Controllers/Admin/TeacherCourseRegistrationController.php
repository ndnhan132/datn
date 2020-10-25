<?php

namespace App\Http\Controllers\Admin;

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
