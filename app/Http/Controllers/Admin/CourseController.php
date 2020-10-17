<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Course\CourseRepositoryInterface;

class CourseController extends Controller
{
    protected $courseRepository;

    public function __construct(CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function index()
    {
        $courses = $this->courseRepository->index();
        return view('admin.course.index', compact('courses'));
    }

    public function ajaxGetTableContent(Request $request)
    {

        isset($request['recordPerPage']) ? $recordPerPage = $request['record-per-page'] : $recordPerPage = 10;
        isset($request['page']) ? ($page = $request['page']) : ($page = 1);
        $startFrom = ($page - 1) * $recordPerPage;

        $courses = $this->courseRepository->pagination($startFrom, $recordPerPage);
        $count = $this->courseRepository->index()->count();

        if ($count % $recordPerPage) {
            $max = floor($count / $recordPerPage) + 1;
        } else {
            $max = floor($count / $recordPerPage);
        }

        return view('admin.course.index-table', compact(['courses', 'max', 'page']));
    }
}
