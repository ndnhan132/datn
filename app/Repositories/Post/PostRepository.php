<?php

namespace App\Repositories\Post;

use App\Repositories\BaseRepository;
use App\Models\Post;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    public function getModel()
    {
        return Post::class;
    }

    public function findNewsBySlug($slug)
    {
        return $this->model->where('slug', $slug)->first();
    }
    public function getNewsWithPagination($startFrom, $recordPerPage)
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
