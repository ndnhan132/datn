<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Repositories\Course\CourseRepositoryInterface;
use App\Repositories\Subject\SubjectRepositoryInterface;
use App\Repositories\CourseLevel\CourseLevelRepositoryInterface;

class HomeController extends Controller
{
    protected $courseRepository;
    protected $subjectRepository;
protected $courseLevelRepository;

    public function __construct(
        CourseRepositoryInterface $courseRepository,
        SubjectRepositoryInterface $subjectRepository,
        CourseLevelRepositoryInterface $courseLevelRepository
        )
    {
        $this->courseRepository = $courseRepository;
        $this->subjectRepository = $subjectRepository;
        $this->courseLevelRepository = $courseLevelRepository;
    }
    public function index()
    {
        $courses = $this->courseRepository->getHomeCourse(5);
        $subjects = $this->subjectRepository->index();
        $courseLevels = $this->courseLevelRepository->index();
        \Debugbar::debug($courses);
        \Debugbar::debug($subjects);
        \Debugbar::debug($courseLevels);
        return view('front.home.index', compact(['courses', 'subjects', 'courseLevels']));
    }
}
