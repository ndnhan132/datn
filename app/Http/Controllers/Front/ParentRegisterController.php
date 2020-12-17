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
// require 'vendor/autoload.php';
use App\Helper\MailHelper;

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
    private $mailHelper;

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
        $this->mailHelper = new MailHelper();
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
                'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
                'email' => 'required|max:50|email:rfc,dns',
                'address' => 'required|max:50',
                'time_working' => 'required|max:50',
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute dài quá mức cho phép',
                'email' => ':attribute không đúng định dạng',
                'regex' => ':attribute không đúng định dạng',
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
            $check7day = $this->parentRegisterRepository->checkCanRegister7day($request);
            if($check7day){
                $checkDupli = $this->parentRegisterRepository->checkCanRegisterDuplicateTeacher($request);
                if($checkDupli){
                    $reg = $this->parentRegisterRepository->store($request);
                    if($reg['success']){
                        $this->sendRegisterEmailForParent($reg['record']);
                        $success = true;
                    }
                }
                else{
                    $message = array('time' => 'Bạn đã đăng ký lớp này rồi. Xin vui lòng chờ đợi!');
                }
            }
            else{
                $message = array('time' => 'Bạn đã đăng ký lớp này gần dây, Chờ sau 7 ngày để đăng ký lại.!');
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

    private function sendRegisterEmailForParent($reg)
    {
        $recipientMail = $reg->email ?? '';
        $recipientName = $reg->fullname ?? 'Quý Khách Hàng';
        $subject = "[ĐĂNG KÝ TÌM GIA SƯ THÀNH CÔNG]";
        $courseLevel = $reg->course->courseLevel->display_name;
        $subjectName = $reg->course->subject->display_name ?? '';
        $teacherName = $reg->teacher->name ?? '';
        $teacherLevel = $reg->teacher->getGenderAndLevel() ?? '';
$message = <<<EOF
<p>Kính chào {$recipientName} !</p>
<p>Quý vị đã đăng ký tìm gia sư thành công tại Trung tâm gia sư Đà Nẵng.</p>
<p>Thông tin đăng ký:</p>
<ul>
<li><b>Người đăng ký     : </b>{$recipientName}</li>
<li><b>Email             : </b>{$reg->email}</li>
<li><b>Số điện thoại     : </b>{$reg->phone}</li>
<li><b>Địa chỉ           : </b>{$reg->address}</li>
<li><b>Đăng ký lớp học   : </b>{$courseLevel}</li>
<li><b>Đăng ký môn học   : </b>{$subjectName}</li>
<li><b>Học phí           : </b>{$reg->tuition_per_session}</li>
<li><b>Thời gian         : </b>{$reg->time_working}</li>
<li><b>Giáo viên đăng ký : </b>{$teacherName }</li>
<li><b>Trình độ giáo viên: </b>{$teacherLevel}</li>
</ul>

<p>Chúng tôi sẽ xem xét đăng ký của bạn trong thời gian sớm nhất có thể.</p>
Xin trân trọng!
EOF;
        try{
            $this->mailHelper->sendEmail($recipientMail, $recipientName, $subject, $message);
            return;
        } catch(Exception $e){
            Log::debug('send mail fail');
            return;
        }
    }
}
