<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Teacher\TeacherRepositoryInterface;
use Illuminate\Support\Facades\Log;
use App\Repositories\TeacherLevel\TeacherLevelRepositoryInterface;

class TeacherController extends Controller
{
    protected $teacherRepository;
    protected $teacherLevelRepository;
    public function __construct(
        TeacherLevelRepositoryInterface $teacherLevelRepository,
        TeacherRepositoryInterface $teacherRepository
        )
    {
        $this->teacherRepository = $teacherRepository;
        $this->teacherLevelRepository = $teacherLevelRepository;
    }

    public function index()
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        return view('admin.teacher.index');
    }
    public function ajaxGetTableContent(Request $request)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        isset($request['record_per_page']) ? $recordPerPage = $request['record_per_page'] : $recordPerPage = 10;
        isset($request['page']) ? ($page = $request['page']) : ($page = 1);
        $startFrom = ($page - 1) * $recordPerPage;
        $teacherAccountStatus = false;
        if(isset($request['teacher_account_status'])){
            $teacherAccountStatus = $request['teacher_account_status'];
        }
        $teacherLevelId = false;
        if(isset($request['teacher_level'])){
            $teacherLevelId = $request['teacher_level'];
        }
        $searchText = false;
        if(isset($request['search_text'])){
            $searchText = $request['search_text'];
        }
        $searchCriterion = false;
        if(isset($request['search_criterion'])){
            $searchCriterion = $request['search_criterion'];
        }

        $teacherLevels = $this->teacherLevelRepository->index();
        $res = $this->teacherRepository->pagination($startFrom, $recordPerPage, $teacherAccountStatus, $teacherLevelId, $searchText, $searchCriterion);
        $count = $res['count'];
        $teachers = $res['data'];

        if ($count % $recordPerPage) {
            $max = floor($count / $recordPerPage) + 1;
        } else {
            $max = floor($count / $recordPerPage);
        }

        return view('admin.teacher.main-table', compact(['teachers', 'max', 'page', 'startFrom', 'recordPerPage', 'count', 'teacherAccountStatus', 'teacherLevels', 'teacherLevelId', 'searchText', 'searchCriterion' ]));
    }

    public function ajaxShow(Request $request, $teacherId)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        if($teacherId){
            $teacher = $this->teacherRepository->find($teacherId);
            // $canConfirm = (isset($request['can-confirm']) && $request['can-confirm'] == 'yes') ? true : false;
            if($teacher) {
                $html = view('admin.teacher.detail', compact(['teacher']));
                $html = strval($html);
                $html = trim($html);

                return response()->json(array(
                    'success' => true,
                    'data'    => null,
                    'html'    => $html,
                ));
            }
        }

        return response()->json(array(
            'success' => false,
            'message' => 'Có lỗi xảy ra!',
        ));
    }

    public function ajaxConfirm(Request $request)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        $teacherId = ($request['teacherId']) ? $request['teacherId'] : '';
        $isActive = (isset($request['isActive'])) ? $request['isActive'] : '';
        if($teacherId != '') {
            return response()->json(array(
                'success' => $this->teacherRepository->confirm($teacherId, $isActive),
                'message' => '',
            ));
        }

        return response()->json(array(
            'success' => 'false',
            'message' => 'Có lỗi xảy ra!'
        ));
    }
}
