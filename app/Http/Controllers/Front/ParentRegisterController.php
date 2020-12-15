<?php

namespace App\Http\Controllers\Front;

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
use Validator;
use Carbon\Carbon;

class ParentRegisterController extends Controller
{
    //
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




    public function ajaxParentRegisterPreviewTeacher(Request $request, $teacherId)
    {
        $teacher = $this->teacherRepository->find($teacherId);
        if($teacher) {
            $html = view('front.parent-register.teacher-detail', compact(['teacher']));
            $html = strval($html);
            $html = trim($html);

            return response()->json(array(
                'success' => true,
                'data'    => null,
                'html'    => $html,
            ));
        }
    }

    public function ajaxStore(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'select_teacher' => 'required',
                'select_course' => 'required',
                'fullname' => 'required|max:50',
                'phone' => 'required',
                'email' => 'required|max:50|email:rfc,dns',
                'address' => 'required|max:50',
                'time_working' => 'required|max:50',
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute dài quá mức cho phép',
                'email' => ':attribute không đúng định dạng',
            ],
            [
                'select_teacher' => 'Giáo viên',
                'select_course' => 'Khoá học',
                'fullname' => 'Họ tên',
                'phone' => 'Điện thoại',
                'email' => 'Email',
                'address' => 'Địa chỉ',
                'time_working' => 'Thời gian dạy'
            ]
        );

        $success = false;
        $message = '';
        if ($validator->passes()) {
            $check = $this->parentRegisterRepository->checkCanRegister($request);
            if($check){
                $reg = $this->parentRegisterRepository->store($request);
                if($reg){
                    $success = true;
                }
            }else{
                $message = array('time' => 'Bạn chỉ được đăng ký lớp này gần dây, Chờ sau 7 ngày để đăng ký lại.!');
            }
        }else{
            $message = $validator->errors()->all();
        }

        return response()->json(array(
            'success' => $success,
            'message' => $message,
        ));
    }

    public function ajaxGetParentRegisterById($parentRegisterId, Request $request)
    {
        $reg = $this->parentRegisterRepository->findWithData($parentRegisterId);
        $success = false;
        $data = false;
        if($reg) {
            $success = true;
            $data =array(
                'id' => $reg->id,
                'title' => $reg->course->title,
                'subject' => $reg->course->subject->display_name ?? '',
                'fullname' => $reg->fullname,
                'email' => $reg->email,
                'phone' => $reg->phone,
                'address' => $reg->address,
                'course_level' => $reg->course->courseLevel->display_name ?? '',
                'session_per_week' => $reg->course->session_per_week ?? '',
                'created_at' => (new Carbon($reg->created_at))->setTimeZone('Asia/Ho_Chi_Minh')->isoFormat('DD/MM/YYYY') ?? '--/--/----',
                'tuition_per_session' => $reg->getDisplayTution(),
                'time_working' => $reg->time_working,
                'isReceived' => $reg->flag_is_confirmed,

            );
        }
        return response()->json(array(
            'success' => $success,
            'data' => $data,
        ));
    }
}
