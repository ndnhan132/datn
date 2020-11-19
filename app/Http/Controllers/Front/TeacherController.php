<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\Teacher\TeacherRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



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
        return $this->teacherRepository->store($request);
    }

    public function ajaxLogin(Request $request)
    {
        if(Auth::guard('teacher')->check()) dd('Đã đăng nhập');
        // $email = 'testteacher@gmail.com';
        // $password = '111111';
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
                $credentials = $request->only('email', 'password');
                $remember = ($request->input('remember')) ? '1' : '0';
                if (Auth::guard('teacher')->attempt($credentials, $remember)) {
                    if(Auth::guard('teacher')->check()) {
                        $message = 'Đăng nhập thành công.';
                        $success = true;
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
        //  dd(Auth::guard('teacher')->check());
        // dd($message);
        return response()->json(array(
            'success' => $success,
            'message' => $message,
        ));
    }

    public function logout()
    {
        Auth::guard('teacher')->logout();
        return response()->json(array(
            'success' => !Auth::guard('teacher')->check()
        ));
    }

    public function ajaxLoadTeacherLoginBox()
    {
        return view('front.layouts.asidebar.teacher-login-box');
    }

    public function getForTeacherPage()
    {
        return view('front.teacher.for-teacher');
    }

}
