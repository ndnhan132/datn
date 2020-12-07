<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class PageController extends Controller
{
    protected $userRepository;
    // protected $optionRepository;
    public function __construct(
        UserRepositoryInterface $userRepository
        // ,OptionRepositoryInterface $optionRepository
        )
    {
        $this->userRepository = $userRepository;
        // $this->optionRepository = $optionRepository;
    }
    public function upload(Request $request)
    {
        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;

            $request->file('upload')->move(public_path('ckeditor'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('ckeditor/'.$fileName);
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }

    public function getLogin()
    {
        if(Auth::check()){
            return redirect()->route('admin.dashboard.index');
        }else{
            return view('admin.login.index');
        }
    }

    public function postLogin(Request $request)
    {
        if($this->userRepository->login($request)){
            return redirect()->route('admin.dashboard.index');
        }else{
            return redirect()->route('admin.getLogin');
        }
    }

    public function ajaxPostLogin(Request $request)
    {
        if(Auth::check()) {
            return response()->json(array(
                'success' => true,
            ));
        }
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|max:50|email:rfc,dns',
                'password' => 'required|max:50',
            ],
            [
                'required' => ':attribute không được để trống',
                'confirmed' => ':attribute không khớp nhau',
                'max' => ':attribute quá dài',
                'email' => ':attribute không hợp lệ',
            ],
            [
                'email' => 'Email',
                'password' => 'Mật khẩu',
            ]
        );
        $success = false;
        $message = 'Đăng nhập không thành công.';
        if ($validator->passes()) {
            $email = $request->input('email');
            $password = $request->input('password');
            $tmpUser = $this->userRepository->findByEmail($email);
            if($tmpUser) {
                if(Hash::check($password, $tmpUser->password)) {
                    // $data = [
                    //     'email' => $email,
                    //     'password' => $password,
                    // ];
                    if(!$tmpUser->email_verified_at){
                        $message = array('errors' => 'Tài khoản chưa được kích hoạt !');
                    }else{
                        $credentials = $request->only('email', 'password');
                        $remember = ($request->input('remember')) ? '1' : '0';
                        if ($this->userRepository->login($request)) {
                            $message = array('errors' => 'Đăng nhập thành công.');
                            $success = true;
                        }
                    }
                }
                else {
                    $message = array('errors' => 'Mật khẩu không chính xác !');
                }
            }
            else {
                $message = array('errors' => 'Email ko tồn tại !');
            }
        }
        else{
            $message = $validator->errors()->all();
        }
        return response()->json(array(
            'success' => $success,
            'message' => $message,
        ));
    }

    public function logout()
    {
        $this->userRepository->logout();
            return redirect()->route('admin.getLogin');
    }
}
