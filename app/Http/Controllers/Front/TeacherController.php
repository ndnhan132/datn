<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Teacher\TeacherRepositoryInterface;
use Illuminate\Support\Facades\Auth;


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
        return view('front.teacher.teacher-register');
    }

    public function ajaxStore(Request $request)
    {
        return $this->teacherRepository->store($request);
    }

    public function login(Request $request)
    {
        $email = 'testteacher@gmail.com';
        $password = '111111';
        // dd(Auth::guard('teacher'));
        if (Auth::guard('teacher')->attempt(['email' => $email, 'password' => $password])) {
            dd(Auth::guard('teacher')->user()->name);
            dd(Auth::guard('teacher')->check());
        }
    }
    public function logout()
    {
        // if(Auth::check())
        // {
        //     Auth::logout();
        // }
        // dd('Logout');
        dd(Auth::check());
        dd(Auth::guard('teacher'));
    }
}
