<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Teacher\TeacherRepositoryInterface;

class TeacherController extends Controller
{
    protected $teacherRepository;

    public function __construct(TeacherRepositoryInterface $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }

    public function index()
    {
        $teachers = $this->teacherRepository->index();
        return view('admin.teacher.index', compact('teachers'));
    }
}
