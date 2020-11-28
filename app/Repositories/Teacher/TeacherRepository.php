<?php

namespace App\Repositories\Teacher;

use App\Repositories\BaseRepository;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;

class TeacherRepository extends BaseRepository implements TeacherRepositoryInterface
{
    public function getModel()
    {
        return Teacher::class;
    }

    public function store($request)
    {
        $teacher = new Teacher();
        $teacher->name = $request['name'] ?? '';
        $teacher->email = $request['email'];
        $teacher->password = bcrypt($request['password']);
        $teacher->last_modified = time();

        if($teacher->save()){
            return $teacher;
        }
        return false;
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
    // public function markAsChecked($teacher)
    // {
    //     $teacher->find($teacher)->flag_is_checked = true;
    //     return $teacher->save();
    // }

    public function confirm($teacherId, $isActive)
    {
        $teacher = $this->model->find($teacherId);
        $teacher->flag_is_teacher = $isActive;
        $teacher->flag_is_checked = true;
        return $teacher->save();
    }

    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function updateGeneral($request)
    {
        $teacher = $this->model->find(Auth::guard('teacher')->user()->id);
        $teacher->name = $request->input('name');
        $teacher->address = $request->input('address');
        $teacher->phone = $request->input('phone');
        $teacher->is_male = $request->input('is_male');
        $teacher->description = $request->input('description');
        $teacher->identity_card = $request->input('identity_card');
        $teacher->year_of_birth = $request->input('year_of_birth');
        $teacher->last_modified = time();
        return $teacher->save();
    }

    public function updatePassword($request)
    {
        $teacher = $this->model->find(Auth::guard('teacher')->user()->id);
        $teacher->password = bcrypt($request->input('password'));
        return $teacher->save();
    }

    public function updateEducation($request)
    {
        $teacher = $this->model->find(Auth::guard('teacher')->user()->id);
        $teacher->university = $request->input('university');
        $teacher->speciality = $request->input('speciality');
        $teacher->teacher_level_id = $request->input('teacher_level_id');
        $teacher->reference_tuition = $request->input('reference_tuition');
        return $teacher->save();
    }
    public function verifyEmail($id)
    {
        $teacher = $this->model->find($id);
        $teacher->email_verified_at = now();
        return $teacher->save();
    }
}
