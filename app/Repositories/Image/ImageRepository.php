<?php

namespace App\Repositories\Image;

use App\Repositories\BaseRepository;
use App\Models\Image;

class ImageRepository extends BaseRepository implements ImageRepositoryInterface
{
    public function getModel()
    {
        return Image::class;
    }
    public function updateTeacherAvatar($src, $teacherId, $imageData)
    {
        $image_array_1 = explode(";", $imageData);
        $image_array_2 = explode(",", $image_array_1[1]);
        $data = base64_decode($image_array_2[1]);
        file_put_contents($src, $data);
        $image = $this->model->where([
            ['teacher_id', '=', $teacherId],
            ['image_type', '=', 'TEACHER_AVATAR']
        ])->first();
        if(!$image) {
            $image = new Image();
            $image->teacher_id = $teacherId;
            $image->image_type = 'TEACHER_AVATAR';
        }
        $image->src = $src;

        return $image->save();
    }
}
