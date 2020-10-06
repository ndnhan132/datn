<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;
use Auth;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

    public function logout()
    {
        return Auth::logout();
    }
    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function login($request)
    {
        $credentials = $request->only('email', 'password');
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
        $remember = ($request->input('remember')) ? true : false;
        return Auth::attempt($credentials, $remember);
    }

    public function pagination($startFrom, $recordPerPage)
    {
        return $this->model->orderBy('id', 'DESC')
            ->offset($startFrom)
            ->limit($recordPerPage)
            ->get();
    }

    public function store($request)
    {
        $users = new User();
        $users->email = $request->email;
        // $users->password = bcrypt($request->password);
        return $users->save();
    }

    public function update($id, $request)
    {
        $users = $this->model->find($id);
        $users->password = bcrypt($request->password);
        return $users->save();
    }
    public function updatePassword($id, $passwordText)
    {
        $user = $this->model->find($id);
        $user->password = bcrypt($passwordText);
        $user->password_text = $passwordText;
        return $user->save();
    }
    public function getLoginEmailUrl($user, $remember)
    {
        $data = [
            'email' => $user->email,
            'password' => $user->password_text,
        ];
        $remember = ($remember == "true") ? true : false;
        return Auth::attempt($data, $remember);
    }
}
