<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Teacher\TeacherRepositoryInterface;
use App\Repositories\TeacherLevel\TeacherLevelRepositoryInterface;
use App\Repositories\Image\ImageRepositoryInterface;
use App\Repositories\TeacherCourseRegistration\TeacherCourseRegistrationRepositoryInterface;
use App\Repositories\Course\CourseRepositoryInterface;
use App\Repositories\CourseLevel\CourseLevelRepositoryInterface;
use App\Repositories\Subject\SubjectRepositoryInterface;
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
    protected $courseRepository;
    protected $teacherCourseRegistrationRepository;
    protected $courseLevelRepository;
    protected $subjectRepository;

    public function __construct(
        TeacherRepositoryInterface $teacherRepository,
        TeacherLevelRepositoryInterface $teacherLevelRepository,
        ImageRepositoryInterface $imageRepository,
        TeacherCourseRegistrationRepositoryInterface $teacherCourseRegistrationRepository,
        CourseLevelRepositoryInterface $courseLevelRepository,
        SubjectRepositoryInterface $subjectRepository,
        CourseRepositoryInterface $courseRepository
        )
    {
        $this->teacherRepository = $teacherRepository;
        $this->teacherLevelRepository = $teacherLevelRepository;
        $this->imageRepository = $imageRepository;
        $this->courseRepository = $courseRepository;
        $this->teacherCourseRegistrationRepository = $teacherCourseRegistrationRepository;
        $this->subjectRepository = $subjectRepository;
        $this->courseLevelRepository = $courseLevelRepository;
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
            $courseLevels = '';
            $subjects = '';
            if($settingType == 'hoc-van'){
                $courseLevels = $this->courseLevelRepository->index();
                $subjects = $this->subjectRepository->index();
            }
            return view('front.teacher-manager.' . $settingType, compact(['courseLevels', 'subjects']));
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
        $validator = Validator::make(
            $request->all(),
            [
                'university' => 'nullable|max:100',
                'speciality' => 'nullable|max:50',
                'teacher_level_id' => 'required',
                'reference_tuition' => 'nullable|numeric',
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute quá dài',
                'numeric' => ':attribute phải là số',
            ],
            [
                'university' => 'Đại học',
                'speciality' => 'Chuyên ngành',
                'teacher_level_id' => 'Trình độ giáo viên',
                'reference_tuition' => 'Học phí',
            ]
        );
        $message = false;
        $success = false;
        if ($validator->passes()) {
            $success = $this->teacherRepository->updateEducation($request);
        } else {
            $message =  $validator->errors()->all();
        }
        return response()->json([
            'success' => $successzf,
            'message' => $message,
        ]);
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
    public function ajaxGetCourseById(Request $request, $courseId)
    {
        $course = $this->courseRepository->findWithData($courseId);
        return response()->json(array(
            'success' => true,
            'data' => $course,
        ));
    }

    public function getRegistrationCourse()
    {
        return view('front.teacher-manager.registration-course');
    }

    public function ajaxDeleteCourse(Request $request)
    {
        $teacherId = Auth::guard('teacher')->user()->id;
        $courseId = $request['courseId'];
        $success = $this->teacherCourseRegistrationRepository->deleteRegistration($courseId, $teacherId);
        $registrations = $this->teacherCourseRegistrationRepository->getMyRegistration($teacherId);
        $html     = view('front.teacher-manager.all-course', compact('registrations'));
        $html     = strval($html);
        $html     = trim($html);
        return response()->json(array(
            'success' => boolval($success),
            'html' => $html,
        ));
    }

    public function ajaxSendRequestConfirmation(Request $request)
    {
        $teacherId = Auth::guard('teacher')->user()->id;
        $success = false;
        $message = false;
        if(Auth::guard('teacher')->user()->canSendRequestConfirmation()) {
            $success = $this->teacherRepository->sendRequestConfirmation($teacherId);
        }
        else {
            $message = 'Không thể yêu cầu xét duyệt lúc này.';
        }
        return response()->json(array(
            'success' => $success,
            'message' => $message,
        ));
    }
}
