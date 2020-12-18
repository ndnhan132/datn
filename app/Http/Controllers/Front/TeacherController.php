<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\Teacher\TeacherRepositoryInterface;
use App\Repositories\TeacherLevel\TeacherLevelRepositoryInterface;
use App\Repositories\CourseLevel\CourseLevelRepositoryInterface;
use App\Repositories\Subject\SubjectRepositoryInterface;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Load Composer's autoloader
// require 'vendor/autoload.php';
// require 'vendor/autoload.php';
use App\Helper\MailHelper;

class TeacherController extends Controller
{

    protected $teacherRepository;
    protected $courseLevelRepository;
    protected $teacherLevelRepository;
    protected $subjectRepository;
    private $mailHelper;

    public function __construct(
        TeacherRepositoryInterface $teacherRepository,
        TeacherLevelRepositoryInterface $teacherLevelRepository,
        CourseLevelRepositoryInterface $courseLevelRepository,
        SubjectRepositoryInterface $subjectRepository
        )
    {
        $this->teacherRepository = $teacherRepository;
        $this->teacherLevelRepository = $teacherLevelRepository;
        $this->subjectRepository = $subjectRepository;
        $this->courseLevelRepository = $courseLevelRepository;
         $this->mailHelper = new MailHelper();
    }

    public function getTeacherRegisterPage()
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        return view('front.teacher.teacher-register');
    }

    public function ajaxStore(Request $request)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email:rfc,dns|max:50|unique:teachers',
                'password' => 'required|max:30|confirmed',
                // 'password_confirmation' => 'required|confirmed|max:30',
            ],
            [
                'required' => ':attribute không được để trống',
                'confirmed' => ':attribute không khớp nhau',
                'email' => ':attribute không hợp lệ',
                'max' => ':attribute độ dài vượt quá :max ký tự',
                'unique' => ':attribute đã được sử dụng',
            ],
            [
                'current_password' => 'Mật khẩu',
                'password' => 'Mật khẩu',
                'email' => 'Email',
            ]
        );
        $success = false;
        $message = 'Có lỗi xảy ra!';
        $redirect = '';
        $html = '';
        if ($validator->passes()) {
            $tmpTeacher = $this->teacherRepository->findByEmail($request['email']);
            if($tmpTeacher) {
                $message = 'Email đã được sử dụng';
            }
            else{
                $teacher =  $this->teacherRepository->store($request);
                if($teacher){
                    $this->sendActiveTeacherAccountMail($teacher);
                    $credentials = $request->only('email', 'password');
                    $success = true;
                }
            }
            $html = view('front.teacher.register-result', compact(['success']));
            $html = strval($html);
            $html = trim($html);
        }else{
            $message = $validator->errors()->all();
        }
        return response()->json(array(
            'success'  => $success,
            'message'  => $message,
            'html' => $html,
        ));
    }

    public function ajaxLogin(Request $request)
    {
        Log::debug('ajaxLogin');
        Log::debug($request->all());
        if(Auth::guard('teacher')->check()){
            return redirect()->route('front.home');
        };
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email:rfc,dns|max:50',
                'password' => 'required|max:30',
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute tối đa :max ký tự',
                'email' => ':attribute không hợp lệ'
            ],
            [
                'email' => 'Email',
                'password' => 'Mật khẩu',
            ]
        );
        $success = false;
        $message = 'Đăng nhập không thành công.';
        if ($validator->passes()) {
            $email = $request->input('email');
            $password = $request->input('password');
            $tmpTeacher = $this->teacherRepository->findByEmail($email);
            if($tmpTeacher) {
                if(Hash::check($password, $tmpTeacher->password)) {
                    // $data = [
                    //     'email' => $email,
                    //     'password' => $password,
                    // ];
                    if(!$tmpTeacher->email_verified_at){
                        $message = 'Tài khoản chưa được kích hoạt !';
                    }else{
                        $credentials = $request->only('email', 'password');
                        $remember = ($request->input('remember')) ? '1' : '0';
                        if (Auth::guard('teacher')->attempt($credentials, $remember)) {
                            if(Auth::guard('teacher')->check()) {
                                $message = 'Đăng nhập thành công.';
                                $success = true;
                            }
                        }
                    }
                }
                else {
                    $message = 'Mật khẩu không chính xác !';
                }
            }
            else {
                $message = 'Email ko tồn tại !';
            }
        } else {
            $message =  $validator->errors()->all();
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);

        return response()->json(array(
            'success' => $success,
            'message' => $message,
        ));
    }

    public function ajaxLogout()
    {
        Auth::guard('teacher')->logout();
        return response()->json(array(
            'success' => !Auth::guard('teacher')->check()
        ));
    }
    public function logout()
    {
        Auth::guard('teacher')->logout();
        return redirect()->back();
    }
    public function ajaxLoadTeacherLoginBox()
    {
        return view('front.layouts.asidebar.teacher-login-box');
    }

    public function sendActiveTeacherAccountMail($teacher)
    {
        // $webMail = 'ndnhans1@gmail.com';
        // $webMailPass = 'ndnhan187539115';
        // $webMailName = 'Gia Sư Đà Nẵng';


        $recipientMail = $teacher->email;
        // $recipientMail = 'ndnhan132@gmail.com';
        $teacherName = $teacher->name ?? 'Quý vị';
        $recipientName = $teacherName ;
        $subject = 'KÍCH HOẠT TÀI KHOẢN';
        $href = route('front.verifyTeacherEmail');
        $now = time();
        $id = $teacher->id;
        $hashKey = $now . $id;
        $hashKey = hash('sha256', $hashKey);
        $hashKey = strtolower($hashKey);
        $href .= '?hkey=' . $hashKey . '&uid=' . $id . '&t=' . $now;
        $message = <<<EOF
<p>Kính chào {$teacherName} !</p>
<p>Quý vị đã đăng ký thành viên tại Trung tâm gia sư Đà Nẵng.</p>
<p>Xin vui lòng <a href="{$href}">Nhấn vào đây</a> để xác nhận tài khoản của bạn.</p>

<p>Sau khi kích hoạt bạn có thể sử dụng {$recipientMail} để đăng nhập.</p>
Xin trân trọng!
EOF;

    try{
        $this->mailHelper->sendEmail($recipientMail, $recipientName, $subject, $message);
        return true;
    } catch(Exception $e){
        Log::debug('send mail fail');
        return false;
    }

        // $debug = false;
        // $mail = new PHPMailer(true);
        // try{
        //     try {
        //         // Server settings
        //         // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        //         $mail->SMTPDebug =  ($debug) ? SMTP::DEBUG_SERVER : SMTP::DEBUG_OFF ;
        //         $mail->isSMTP();                                            // Send using SMTP
        //         $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
        //         $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        //         $mail->Username   = $webMail;                     // SMTP username
        //         $mail->Password   = $webMailPass;                               // SMTP password
        //         $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        //         $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //         $mail->CharSet = 'UTF-8';
        //         //Recipients
        //         $mail->setFrom($webMail, $webMailName);
        //         $mail->clearAllRecipients();
        //     }catch(Exception $e){
        //         $style = '"color: #ff0000;"';
        //         echo "<h1 style={$style}><Strong>Message could not be sent. Mailer Error: {$mail->ErrorInfo} </Strong></h1>";
        //     }

        //     $mail->addAddress($recipientMail, $recipientName);     // Add a recipient
        //     // Content
        //     $mail->isHTML(true);                                  // Set email format to HTML
        //     $mail->Subject = $subject;
        //     $mail->Body    = $message;
        //     $mail->AltBody = $message;

        //     if($mail->send()){
        //         return true;
        //     }else{
        //         return false;
        //     }
        // }catch(Exception $e){
        //     $style = '"color: #ff0000;"';
        //     echo "<h1 style={$style}><Strong>Message could not be sent. Mailer Error: {$mail->ErrorInfo} </Strong></h1>";
        //     return false;
        // }
    }

    public function verifyTeacherEmail(Request $request)
    {
        $success = false;
        $error = '';
        if (isset($request->hkey, $request->uid, $request->t)) {
            $hashRequest = strtoupper($request->hkey);
            $id = $request->uid;
            $time = $request->t;
            if ((intval(time()) - intval($time)) < 6000) { // 10 phut
                $tmpTeacher = $this->teacherRepository->find($id);
                $hashCheck = $time . $id;
                $hashCheck = hash('sha256', $hashCheck);
                $hashCheck = strtoupper($hashCheck);
                if (hash_equals($hashCheck, $hashRequest)) {
                    $rs = $this->teacherRepository->verifyEmail($id);
                    if($rs){
                        Auth::guard('teacher')->login($tmpTeacher);
                        $success = true;
                    }else{
                        $error = 'Lỗi chưa xác định.';
                    }
                }
            }else{
                $this->teacherRepository->destroy($id);
                $error = 'Đường dẫn kích hoạt đã Hết hạn';
            }
        }else{
            $error = 'Đường dãn không chính xác.';
        }
        return view('front.teacher.verify-email', compact(['success', 'error']));
    }

    public function getAllTeachersPage()
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        $recordPerPage = 12;
        $page = 1;
        $startFrom = 0;
        $res     = $this->teacherRepository->getFrontListWithPagination($startFrom, $recordPerPage);
        $total   = $res['total'];
        $teachers = $res['data'];
        $teacherLevels = $this->teacherLevelRepository->index();
        $courseLevels = $this->courseLevelRepository->index();
        $subjects = $this->subjectRepository->index();
        if ($total % $recordPerPage) {
            $max = floor($total / $recordPerPage) + 1;
        } else {
            $max = floor($total / $recordPerPage);
        }
        return view('front.teacher.list-teacher',  compact(['teachers', 'max', 'page', 'total', 'teacherLevels','courseLevels', 'subjects']));
    }

    public function ajaxGetListTeacher(Request $request)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        isset($request['recordPerPage']) ? $recordPerPage = $request['record-per-page'] : $recordPerPage = 12;
        isset($request['page']) ? ($page = $request['page']) : ($page = 1);
        $startFrom = ($page - 1) * $recordPerPage;
        $teacherLevelId = false;
        if(isset($request['teacher_level']) && $request['teacher_level'] != ''){
            $teacherLevelId = $request['teacher_level'];
        }
        $gender = false;
        if(isset($request['gender']) && in_array($request['gender'], array('MALE', 'BOTH', 'FEMALE'))) {
            $gender = $request['gender'];
        }
        $courseLevelId = false;
        if(isset($request['course_level']) && is_numeric($request['course_level'])) {
            $courseLevelId = $request['course_level'];
        }
        $subjectId = false;
        if(isset($request['subject']) && is_numeric($request['subject'])) {
            $subjectId = $request['subject'];
        }


        $res     = $this->teacherRepository->getFrontListWithPagination($startFrom, $recordPerPage, $teacherLevelId, $gender, $courseLevelId, $subjectId);
        $total   = $res['total'];
        $teachers = $res['data'];

        if ($total % $recordPerPage) {
            $max = floor($total / $recordPerPage) + 1;
        } else {
            $max = floor($total / $recordPerPage);
        }
        $html = view('front.teacher.list-teacher-content',  compact(['teachers', 'max', 'page', 'total']));
        $html = strval($html);
        $html = trim($html);

        return response()->json(array(
            'success' => true,
            'html'    => $html,
        ));
    }

    public function ajaxGetTeacherById($teacherId, Request $request)
    {
        $success = false;
        $teacher = $this->teacherRepository->find($teacherId);
        $html = view('front.teacher.detail', compact('teacher'));
        $html = strval($html);
        $html = trim($html);
        if($html) $success = true;
        return response()->json(array(
            'success' => $success,
            'html' => $html,
        ));
    }
}
