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
        $data = $this->model->where('category', 'NEWS')
                    ->orderBy('id', 'DESC')
                    ->offset($startFrom)
                    ->limit($recordPerPage)
                    ->get();
        $total = $this->model->where('category', 'NEWS')->get()->count();

        return array(
            'data' => $data,
            'total' => $total
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
        $imageUpload = $request['image'];
        if($imageUpload) {
            $fileExtension = $request->file('image')->getClientOriginalExtension();
            $fileName = time() . "." . $fileExtension;
            // $uploadPath = public_path('/uploads/post');
            $uploadPath = 'uploads/post';
            if (app()->environment('production')) {
                $uploadPath = 'public/uploads/post';
            }
            elseif (app()->environment('local')) {
                $uploadPath = 'uploads/post';
            }
            $request->file('image')->move($uploadPath, $fileName);
            $image = $uploadPath . '/' . $fileName;
            $post->image = $image;
        }

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

        $imageUpload = $request['image'];
        if($imageUpload) {
            $fileExtension = $request->file('image')->getClientOriginalExtension();
            $fileName = time() . "." . $fileExtension;
            // $uploadPath = public_path('/uploads/post');
            $uploadPath = 'uploads/post';
            if (app()->environment('production')) {
                $uploadPath = 'public/uploads/post';
            }
            elseif (app()->environment('local')) {
                $uploadPath = 'uploads/post';
            }
            $request->file('image')->move($uploadPath, $fileName);
            $image = $uploadPath . '/' . $fileName;
            $post->image = $image;
        }

        return $post->save();
    }

    public function pagination($startFrom, $recordPerPage, $select_category, $searchText)
    {
        $query = $this->model;

        if ($select_category) {
            $query = $query->where('category', $select_category);
        }
        if($searchText) {
            $query = $query->where('title', 'like', '%' . $searchText . '%')
                           ->orWhere('slug', 'like', '%' . $searchText . '%');
        }

        $total = $query->count();
        $data = $query->orderBy('id', 'DESC')
                    ->offset($startFrom)
                    ->limit($recordPerPage)
                    ->get();
        return array(
            'data' => $data,
            'total' => $total
        );
    }

}
