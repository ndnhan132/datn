<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Teacher\TeacherRepositoryInterface;
use App\Repositories\TeacherLevel\TeacherLevelRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TeacherManagerController extends Controller
{
    protected $teacherRepository;
    protected $teacherLevelRepository;
    public function __construct(
        TeacherRepositoryInterface $teacherRepository,
        TeacherLevelRepositoryInterface $teacherLevelRepository
        )
    {
        $this->teacherRepository = $teacherRepository;
        $this->teacherLevelRepository = $teacherLevelRepository;
    }
    public function index()
    {
        return view('front.teacher-manager.index');
    }

    public function ajaxGetTeacherLevel(Request $request)
    {
        return response()->json(array(
            'success' => true,
            'data'    => $this->teacherLevelRepository->index(),
        ));
    }

    public function getManager(Request $request, $settingType)
    {
        if(view()->exists('front.teacher-manager.' . $settingType)) {
            return view('front.teacher-manager.' . $settingType);
        }
    }
    public function ajaxUpdateGeneral(Request $request)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        return response()->json(array(
            'success' => $this->teacherRepository->updateGeneral($request)
        ));
    }
    public function ajaxUpdatePassword(Request $request)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        $validator = Validator::make(
            $request->all(),
            [
                'current_password' => 'required',
                'password' => 'required|confirmed',
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
        if ($validator->passes()) {
            $teacher = Auth::guard('teacher')->user();
            if(Hash::check($request['current_password'], $teacher->password)) {
                return response()->json(array(
                    'success' => $this->teacherRepository->updatePassword($request)
                ));
            }else{
                return response()->json([
                    'success' => false,
                    'message' => "Mật khẩu không chính xác!"
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->all(),
            ]);
        }
    }

    public function ajaxUpdateEducation(Request $request)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        return response()->json(array(
            'success' => $this->teacherRepository->updateEducation($request)
        ));
    }
}
