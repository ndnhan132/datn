<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Post\PostRepositoryInterface;
use Illuminate\Support\Facades\Log;
use Validator;


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


        $select_category = 'NEWS';
        if(isset($request['select_category']))
        {
            if($request['select_category'] == 'PAGE') $select_category = 'PAGE';
        }
        $search_text = false;
        if(isset($request['search_text']) && strlen($request['search_text']) > 0){
            $search_text = $request['search_text'];
        }

        $res = $this->postRepository->pagination($startFrom, $recordPerPage, $select_category, $search_text);
        $total = $res['total'];
        $posts = $res['data'];

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
                                                        'recordPerPage',
                                                        'search_text',
                                                        'select_category'
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
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|max:255|unique:posts,title,'.$request['id'],
                'slug' => 'required|max:255',
                'content' => 'required',
                'image' => 'nullable|image',
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute tối đa :max ký tự',
                'numeric' => ':attribute phải là số',
                'image' => ':attribute không đúng định dạng',
                'unique' => ':attribute đã tồn tại',
            ],
            [
                'title' => 'Tiêu đề',
                'slug' => 'Đường dẫn',
                'content' => 'Nội dung',
                'image' => 'Hình ảnh',
            ]
        );
        $message = false;
        $success = false;
        if ($validator->passes()) {
            $success = $this->postRepository->update($request['id'] , $request);
        } else {
            $message =  $validator->errors()->all();
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
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
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|max:255|unique:posts',
                'slug' => 'required|max:255',
                'content' => 'required',
                'image' => 'nullable|image',
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute tối đa :max ký tự',
                'numeric' => ':attribute phải là số',
                'image' => ':attribute không đúng định dạng',
                'unique' => ':attribute đã tồn tại',
            ],
            [
                'title' => 'Tiêu đề',
                'slug' => 'Đường dẫn',
                'content' => 'Nội dung',
                'image' => 'Hình ảnh',
            ]
        );
        $message = false;
        $success = false;
        if ($validator->passes()) {

            $success = $this->postRepository->store($request);
        } else {
            $message =  $validator->errors()->all();
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);

    }


}
