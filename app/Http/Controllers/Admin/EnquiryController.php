<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\Enquiry\EnquiryRepositoryInterface;

class EnquiryController extends Controller
{
    protected $enquiryRepository;

    public function __construct(
        EnquiryRepositoryInterface $enquiryRepository
        )
    {
        $this->enquiryRepository = $enquiryRepository;
    }

    public function index()
    {
        Log::info($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '~' . __METHOD__);
        return view('admin.enquiry.index');
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

        $enquiry_status = false;
        if(isset($request['enquiry_status']) && in_array($request['enquiry_status'], array('CHECKED', 'UNCHECKED', 'ALL'))){
            $enquiry_status = strval($request['enquiry_status']);
        }
        $search_text = false;
        if(isset($request['search_text'])){
            $search_text = $request['search_text'];
        }

        $res = $this->enquiryRepository->pagination(
                                                        $startFrom
                                                        ,$recordPerPage
                                                        ,$enquiry_status
                                                        ,$search_text
                                                    );
        $total = $res['total'];
        $enquiries = $res['data'];
        if ($total % $recordPerPage) {
            $max = floor($total / $recordPerPage) + 1;
        } else {
            $max = floor($total / $recordPerPage);
        }
        $totalUnChecked = $this->enquiryRepository->getTotalUnchecked();
        return view('admin.enquiry.main-table', compact([
                                                        'enquiries',
                                                        'max',
                                                        'page',
                                                        'startFrom',
                                                        'recordPerPage',
                                                        'total',
                                                        'totalUnChecked',
                                                        'enquiry_status',
                                                        'search_text',
                                                    ]));
    }

    public function ajaxShow(Request $request, $enquiryId)
    {
        $enquiry = $this->enquiryRepository->find($enquiryId);
        return response()->json(array(
            'success' => boolval(!!$enquiry),
            'data' => $enquiry,
        ));
    }
    public function ajaxDelete(Request $request) {
        $success = false;
        $message = false;
        if(isset($request['recordId'])) {
            $id = $request['recordId'];
            if(!$this->enquiryRepository->find($id)->flag_is_checked) {
                $message = "Không thể xóa liên hệ chưa xử lý!";
            }
            elseif($this->enquiryRepository->destroy($id)) {
                $success = true;
            }
        }
        return response()->json(array(
            'success' => $success,
            'message' => $message,
        ));
    }

    public function ajaxChangeStatus(Request $request)
    {
        $success = false;
        if(isset($request['isChecked'], $request['recordId']))
        {
            $isChecked = $request['isChecked'];
            $recordId = $request['recordId'];
            if($isChecked == 'YES' || $isChecked == 'NO'){
                $isChecked = ($isChecked == 'YES');
                if($this->enquiryRepository->changeStatus($recordId, $isChecked)){
                    $success = true;
                }
            }
        }

        return response()->json(array(
            'success' => $success,
        ));
    }
}
