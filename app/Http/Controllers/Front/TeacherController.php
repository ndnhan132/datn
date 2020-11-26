<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\Teacher\TeacherRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Load Composer's autoloader
// require 'vendor/autoload.php';

class TeacherController extends Controller
{

    protected $teacherRepository;
    public function __construct(
        TeacherRepositoryInterface $teacherRepository
        )
    {
        $this->teacherRepository = $teacherRepository;
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
            // $course = $this->courseRepository->store($request);
            $tmpTeacher = $this->teacherRepository->findByEmail($request['email']);
            if($tmpTeacher) {
                $message = 'Email đã được sử dụng';
            }
            else{
                $teacher =  $this->teacherRepository->store($request);
                if($teacher){

                    $this->sendActiveTeacherAccountMail($teacher);
                    $credentials = $request->only('email', 'password');
                    // Auth::guard('teacher')->attempt($credentials);
                    $success = true;
                    // $redirect = route('front.teacherManager.index');
                }
            }
        }else{
            $message = $validator->errors()->all();
        }
        $html = view('front.teacher.register-result', compact(['success']));
        $html = strval($html);
        $html = trim($html);
        return response()->json(array(
            'success'  => $success,
            'message'  => $message,
            'html' => $html,
        ));
    }

    public function ajaxLogin(Request $request)
    {
        if(Auth::guard('teacher')->check()) dd('Đã đăng nhập');
        $email = $request->input('email');
        $password = $request->input('password');
        $success = false;
        $message = 'Đăng nhập không thành công.';
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
        $webMail = 'web.sp.nhan@gmail.com';
        $webMailPass = 'ndnhan187539115';
        $webMailName = 'Gia Sư Đà Nẵng';


        $recipientMail = 'ndnhan132@gmail.com';
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


        $debug = false;
        $mail = new PHPMailer(true);
        try{
            try {
                // Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->SMTPDebug =  ($debug) ? SMTP::DEBUG_SERVER : SMTP::DEBUG_OFF ;
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = $webMail;                     // SMTP username
                $mail->Password   = $webMailPass;                               // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                $mail->CharSet = 'UTF-8';
                //Recipients
                $mail->setFrom($webMail, $webMailName);
                $mail->clearAllRecipients();
            }catch(Exception $e){
                $style = '"color: #ff0000;"';
                echo "<h1 style={$style}><Strong>Message could not be sent. Mailer Error: {$mail->ErrorInfo} </Strong></h1>";
            }

            $mail->addAddress($recipientMail, $recipientName);     // Add a recipient
            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->AltBody = $message;

            if($mail->send()){
                return true;
            }else{
                return false;
            }
        }catch(Exception $e){
            $style = '"color: #ff0000;"';
            echo "<h1 style={$style}><Strong>Message could not be sent. Mailer Error: {$mail->ErrorInfo} </Strong></h1>";
            return false;
        }
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
        $teachers = $this->teacherRepository->index();
        return view('front.teacher.list-teacher', compact('teachers'));
    }
}
