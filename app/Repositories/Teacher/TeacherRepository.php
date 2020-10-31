<?php

namespace App\Repositories\Teacher;

use App\Repositories\BaseRepository;
use App\Models\Teacher;

class TeacherRepository extends BaseRepository implements TeacherRepositoryInterface
{
    public function getModel()
    {
        return Teacher::class;
    }

    public function store($request)
    {
        $teacher = new Teacher();
        $teacher->name = 'test_' . rand();
        $teacher->email = 'test_' . rand() . '@gmail.com';
        $teacher->password = bcrypt('test_' . rand());
        $teacher->phone = 'test_' . rand();
        $teacher->address = 'test_' . rand();
        $teacher->is_male = rand(0, 1);
        $teacher->identity_card = rand(1000, 9000) * rand(1000, 9000);
        $teacher->university = 'test_' . rand();
        $teacher->speciality = 'test_' . rand();
        $teacher->level = 'student';
        $teacher->price = rand(10, 90) . '000000';
        $teacher->fee = rand(10, 50);
        return $teacher->save();
    }

    public function pagination($startFrom, $recordPerPage)
    {
        $data = $this->model->orderBy('id', 'DESC')
                    ->offset($startFrom)
                    ->limit($recordPerPage)
                    ->get();
        $count = $this->model->get()->count();

        return array(
            'data' => $data,
            'count' => $count
        );
    }
}
