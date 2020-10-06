<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function login($request);
    public function logout();
    public function findByEmail($email);
    public function pagination($startFrom, $recordPerPage);
    public function updatePassword($id, $passwordText);
    public function getLoginEmailUrl($user, $remember);
}
