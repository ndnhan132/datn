<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Course\CourseRepositoryInterface;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{

    protected $courseRepository;
    public function __construct(
        CourseRepositoryInterface $courseRepository
        )
    {
        $this->courseRepository = $courseRepository;
    }

    public function getCourseRegisterPage()
    {
        return view('front.course.course-register');
    }

    public function ajaxStore(Request $request)
    {
        return $this->courseRepository->store($request);
    }

    public function getNotReceivedClassPage()
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        $page = 1;
        $startFrom = 0;
        $recordPerPage = 4;
        $confirmedRequired = true;
        $type = 'NOT_RECEIVED';
        $res     = $this->courseRepository->getWithPagination($startFrom, $recordPerPage, $type, $confirmedRequired);
        $count   = $res['count'];
        $courses = $res['data'];

        if ($count % $recordPerPage) {
            $max = floor($count / $recordPerPage) + 1;
        } else {
            $max = floor($count / $recordPerPage);
        }

        return view('front.course.list-class-page', compact(['courses', 'max', 'page', 'type']));
    }

    public function getAllClassPage(Request $request)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        $page = 1;
        $startFrom = 0;
        $recordPerPage = 4;
        $confirmedRequired = true;
        $type    = 'ALL';
        $res     = $this->courseRepository->getWithPagination($startFrom, $recordPerPage,  $type, $confirmedRequired);
        $count   = $res['count'];
        $courses = $res['data'];

        if ($count % $recordPerPage) {
            $max = floor($count / $recordPerPage) + 1;
        } else {
            $max = floor($count / $recordPerPage);
        }

        return view('front.course.list-class-page', compact(['courses', 'max', 'page', 'type']));
    }

    public function ajaxGetListClass(Request $request)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        isset($request['recordPerPage']) ? $recordPerPage = $request['record-per-page'] : $recordPerPage = 4;
        isset($request['page']) ? ($page = $request['page']) : ($page = 1);
        $startFrom = ($page - 1) * $recordPerPage;
        $confirmedRequired = true;
        isset($request['type']) ? ($type = $request['type']) : ($type = 'ALL');
        $res     = $this->courseRepository->getWithPagination($startFrom, $recordPerPage,  $type, $confirmedRequired);
        $count   = $res['count'];
        $courses = $res['data'];
        if ($count % $recordPerPage) {
            $max = floor($count / $recordPerPage) + 1;
        } else {
            $max = floor($count / $recordPerPage);
        }

        return view('front.course.list-class-table', compact(['courses', 'max', 'page']));
    }

}
