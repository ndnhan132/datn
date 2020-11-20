<?php

namespace App\Repositories\Image;

interface ImageRepositoryInterface
{
    public function updateTeacherAvatar($fileName, $teacherId, $imageData);
    public function updateTeacherImage($fileName, $teacherId, $imageData, $type, $action);
    public function delete($imageId, $teacherId);
}
