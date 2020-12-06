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
        $recordPerPage = 10;
        if(isset($request['record_per_page']) && is_numeric($request['record_per_page']) && $request['record_per_page'] > 0) {
            $recordPerPage = $request['record_per_page'];
        }
        $page = 1;
        if(isset($request['page']) && is_numeric($request['page']) && $request['page'] > 1) {
            $page = $request['page'];
        }
        $startFrom = ($page - 1) * $recordPerPage;

        $posts = $this->postRepository->pagination($startFrom, $recordPerPage);
        $total = $this->postRepository->index()->count();

        if ($total % $recordPerPage) {
            $max = floor($total / $recordPerPage) + 1;
        } else {
            $max = floor($total / $recordPerPage);
        }

        return view('admin.post.main-table', compact([
                                                        'posts',
                                                        'max',
                                                        'page',
                                                        'total',
                                                        'startFrom',
                                                        'recordPerPage'
                                                        ]));
    }



    public function ajaxDelete(Request $request) {
        $success = false;
        if(isset($request['recordId'])) {
            $id = $request['recordId'];
            if($this->postRepository->destroy($id)) {
                $success = true;
            }
        }
        return response()->json(array(
            'success' => $success
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
