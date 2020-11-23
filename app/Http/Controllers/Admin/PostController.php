<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Post\PostRepositoryInterface;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    protected $postRepository;

    public function __construct(
        PostRepositoryInterface $postRepository
        )
    {
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        return view('admin.post.index');
    }

    public function ajaxGetTableContent(Request $request)
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        isset($request['recordPerPage']) ? $recordPerPage = $request['record-per-page'] : $recordPerPage = 10;
        isset($request['page']) ? ($page = $request['page']) : ($page = 1);
        $startFrom = ($page - 1) * $recordPerPage;

        $posts = $this->postRepository->pagination($startFrom, $recordPerPage);
        $count = $this->postRepository->index()->count();

        if ($count % $recordPerPage) {
            $max = floor($count / $recordPerPage) + 1;
        } else {
            $max = floor($count / $recordPerPage);
        }

        return view('admin.post.main-table', compact(['posts', 'max', 'page']));
    }



    public function ajaxDelete(Request $request)
    {
        $success = false;
        if($request['id']) {
            $success = $this->postRepository->destroy($request['id']);
        };
        return response()->json(array(
            'success' => $success,
        ));
    }
    public function ajaxGetUpdate(Request $request)
    {
        if($request['id']) {
            $post = $this->postRepository->find($request['id']);
            if($post) {
                $html = view('admin.post.create', compact(['post']));
                $html = strval($html);
                $html = trim($html);
                return response()->json(array(
                    'success' => true,
                    'html'    => $html,
                ));
            }
        }
        return response()->json(array(
            'success' => false,
        ));
    }

    public function ajaxPostUpdate(Request $request)
    {
        $success = $this->postRepository->update($request['id'] , $request);
        return response()->json(array(
            'success' => $success,
        ));
    }

    public function ajaxGetCreate()
    {
        $html = view('admin.post.create');
                $html = strval($html);
                $html = trim($html);
                return response()->json(array(
                    'success' => true,
                    'html'    => $html,
                ));
    }

    public function ajaxPostStore(Request $request)
    {
        $success = $this->postRepository->store($request);
        return response()->json(array(
            'success' => $success,
        ));
    }
}
