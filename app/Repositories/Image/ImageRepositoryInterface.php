<?php

namespace App\Repositories\Image;

interface ImageRepositoryInterface
{
    public function updateTeacherAvatar($src, $teacherId, $imageData);
}
