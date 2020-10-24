<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Teacher\TeacherRepositoryInterface;

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
}
