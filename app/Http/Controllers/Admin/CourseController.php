<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Course\CourseRepositoryInterface;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    protected $courseRepository;

    public function __construct(CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function index()
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        return view('admin.course.index');
    }

    public function ajaxGetTableContent(Request $request)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        isset($request['recordPerPage']) ? $recordPerPage = $request['record-per-page'] : $recordPerPage = 10;
        isset($request['page']) ? ($page = $request['page']) : ($page = 1);
        $startFrom = ($page - 1) * $recordPerPage;

        $courses = $this->courseRepository->pagination($startFrom, $recordPerPage);
        $total = $this->courseRepository->index()->count();

        if ($total % $recordPerPage) {
            $max = floor($total / $recordPerPage) + 1;
        } else {
            $max = floor($total / $recordPerPage);
        }

        return view('admin.course.main-table', compact(['courses', 'max', 'page']));
    }

    public function ajaxShow(Request $request, $courseId)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        if($courseId){
            $course = $this->courseRepository->find($courseId);
            $canConfirm = (isset($request['can-confirm']) && $request['can-confirm'] == 'yes') ? true : false;
            if($course) {
                $html = view('admin.course.detail', compact(['course', 'canConfirm']));
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
            'success' => 'false',
            'message' => 'Có lỗi xảy ra!',
        ));
    }

    public function ajaxConfirm(Request $request)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        $courseId = ($request['courseId']) ? $request['courseId'] : '';
        $isConfirmed = (isset($request['isConfirmed'])) ? $request['isConfirmed'] : '';
        if($courseId != '' && in_array($isConfirmed, array('0', '1'))) {
            return response()->json(array(
                'success' => $this->courseRepository->confirm($courseId, $isConfirmed),
                'message' => '',
            ));
        }

        return response()->json(array(
            'success' => 'false',
            'message' => 'Có lỗi xảy ra!'
        ));
    }
}
