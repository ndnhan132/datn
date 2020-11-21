<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Teacher\TeacherRepositoryInterface;
use App\Repositories\TeacherLevel\TeacherLevelRepositoryInterface;
use App\Repositories\Image\ImageRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TeacherManagerController extends Controller
{
    protected $teacherRepository;
    protected $teacherLevelRepository;
    protected $imageRepository;
    public function __construct(
        TeacherRepositoryInterface $teacherRepository,
        TeacherLevelRepositoryInterface $teacherLevelRepository,
        ImageRepositoryInterface $imageRepository
        )
    {
        $this->teacherRepository = $teacherRepository;
        $this->teacherLevelRepository = $teacherLevelRepository;
        $this->imageRepository = $imageRepository;
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

    public function ajaxUpdateAvatar(Request $request)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        $teacher = Auth::guard('teacher')->user();
        $fileExtension = $request->input('file_extension') ?? 'jpg';
        $fileName      = $request->input('file_name')      ?? (Str::slug($teacher->name, '-') . '.' . $fileExtension);
        $fileData      = $request->input('file_data')      ?? '';
        $fileSrc       = $request->input('file_src')       ?? '';
        $success = false;
        if($teacher->getAvatarSrc() == $fileSrc){
            $success = true;
        }
        else{
            // $fileName = 'uploads/avatar/' . $fileName;
            $success = $this->imageRepository->updateTeacherAvatar($fileName, $teacher->id, $fileData);
        }

        return response()->json(array(
            'success' => $success,
        ));
    }

    public function ajaxUpdateImage(Request $request)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        $teacher = Auth::guard('teacher')->user();
        $fileExtension = $request->input('file_extension') ?? 'jpg';
        $fileName      = $request->input('file_name')      ?? (Str::slug($teacher->name, '-') . '.' . $fileExtension);
        $fileData      = $request->input('file_data')      ?? '';
        $fileType      = $request->input('file_type')      ?? '';
        $success = false;
        $url = '';
        $action = 'replace';
        $action = 'new';
        if($fileType == 'DEGREE' || $fileType == 'IDENTITY'){
            $res = $this->imageRepository->updateTeacherImage($fileName, $teacher->id, $fileData, $fileType, $action);
            if($res) {
                $url = $res;
                $success = true;
            }
        }

        return response()->json(array(
            'success' => $success,
            'url' => asset($url),
        ));
    }

    public function ajaxUpdateDeleteImage(Request $request)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        $success = false;
        if($request['image_id']) {
            $success = $this->imageRepository->delete($request['image_id'], Auth::guard('teacher')->user()->id);
        }
            // $success = true;
        return response()->json(array(
            'success' => $success,
        ));
    }
}
