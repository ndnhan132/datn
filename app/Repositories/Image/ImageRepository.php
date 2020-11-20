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
    public function updateTeacherAvatar($filename, $teacherId, $imageData)
    {
        $src = 'uploads/avatar/' . $fileName;
        $image_array_1 = explode(";", $imageData);
        $image_array_2 = explode(",", $image_array_1[1]);
        $data = base64_decode($image_array_2[1]);
        file_put_contents($src, $data);
        $image = $this->model->where([
            ['teacher_id', '=', $teacherId],
            ['image_type', '=', \App\Models\Image::TEACHER_AVATAR]
        ])->first();
        if(!$image) {
            $image = new Image();
            $image->teacher_id = $teacherId;
            $image->image_type =  \App\Models\Image::TEACHER_AVATAR;
        }
        if (file_exists($image->src)) {
            unlink($image->src);
        }
        $image->src = $src;

        return $image->save();
    }

    public function updateTeacherImage($fileName, $teacherId, $imageData, $type, $action)
    {
        if($type == 'DEGREE'){
            $src = 'uploads/degree/' . $fileName;
            $image_type = \App\Models\Image::TEACHER_DEGREE;
        }
        elseif($type == 'IDENTITY'){
            $src = 'uploads/identity/' . $fileName;
            $image_type = \App\Models\Image::TEACHER_IDENTITY_CARD;
        }
        elseif($type == 'AVATAR'){
            $src = 'uploads/avatar/' . $fileName;
            $image_type = \App\Models\Image::TEACHER_AVATAR;
        }
        else return false;

        $image_array_1 = explode(";", $imageData);
        $image_array_2 = explode(",", $image_array_1[1]);
        $data = base64_decode($image_array_2[1]);
        file_put_contents($src, $data);

        $oldLink ;
        if ($action = 'new'){
            $image = new Image();
            $image->teacher_id = $teacherId;
            $image->image_type =  $image_type;
            $image->src = $src;
        }
        elseif ($action = 'replace') {
            $image = $this->model->where([
            ['teacher_id', '=', $teacherId],
            ['image_type', '=', $image_type]
            ])->first();
            if(!$image) {
                $image = new Image();
                $image->teacher_id = $teacherId;
                $image->image_type =  $image_type;
            }
            if (file_exists($image->src)) {
                unlink($image->src);
            }
            $image->src = $src;
        }
        else return false;

        if($image->save()){
            return $image->src;
        }
        return false;
    }

    public function delete($imageId, $teacherId)
    {
        $image = $this->model->where([
            ['teacher_id', '=', $teacherId],
            ['id', '=', $imageId],
        ])->first();
        if(!$image) return false;
        if (file_exists($image->src)) {
            unlink($image->src);
        }
        return $image->delete();
    }
}
