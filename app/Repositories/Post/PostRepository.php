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

    public function findBySlug($slug)
    {
        return $this->model->where('slug', $slug)->first();
    }

    public function store($request)
    {
        $category = 'PAGE';
        if(isset($request['category']) && $request['category'] == 'NEWS'){
            $category = 'NEWS';
        }
        $post = new Post();
        $post->title = $request['title'];
        $post->slug = $request['slug'];
        $post->category = $category;
        $post->content = $request['content'];
        return $post->save();
    }

    public function update($postId, $request)
    {
        $post = $this->model->find($postId);
        if(!$post) return false;
        $category = 'PAGE';
        if(isset($request['category']) && $request['category'] == 'NEWS'){
            $category = 'NEWS';
        }
        $post->title = $request['title'];
        $post->slug = $request['slug'];
        $post->category = $category;
        $post->content = $request['content'];
        return $post->save();
    }

    public function pagination($startFrom, $recordPerPage)
    {
        return $this->model->orderBy('id', 'DESC')
                    ->offset($startFrom)
                    ->limit($recordPerPage)
                    ->get();
    }
}
