<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Teacher\TeacherRepositoryInterface;
use Illuminate\Support\Facades\Log;

class TeacherManagerController extends Controller
{
    protected $teacherRepository;
    public function __construct(
        TeacherRepositoryInterface $teacherRepository
        )
    {
        $this->teacherRepository = $teacherRepository;
    }
    public function index()
    {
        return view('front.teacher-manager.index');
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
}
