<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\Enquiry\EnquiryRepositoryInterface;
use Validator;

class EnquiryController extends Controller
{
    protected $enquiryRepository;

    public function __construct(
        EnquiryRepositoryInterface $enquiryRepository
        )
    {
        $this->enquiryRepository = $enquiryRepository;
    }
    public function ajaxStore(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:50',
                'email' => 'required|max:50|email:rfc,dns',
                'phone' => 'required',
                'title' => 'required|max:100',
                'content' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute độ dài vượt quá',
                'email' => ':attribute không đúng định dạng',
            ],
            [
                'content' => 'Nội dung',
                'title' => 'Tiêu đề',
                'name' => 'Họ tên',
                'phone' => 'Điện thoại',
                'email' => 'Email',
            ]
        );

        $success = false;
        $message = '';
        if ($validator->passes()) {
            $success = $this->enquiryRepository->store($request);
        }else{
            $message = $validator->errors()->all();
        }

        return response()->json(array(
            'success' => $success,
            'message' => $message,
        ));
    }
}
