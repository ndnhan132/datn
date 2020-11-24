<?php

namespace App\Http\Controllers\Front;

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
    public function ajaxStore(Request $request)
    {
        $success = $this->enquiryRepository->store($request);
        return response()->json(array(
            'success' => $success,
        ));
    }
}
