<?php

namespace App\Repositories\Enquiry;

interface EnquiryRepositoryInterface
{
    public function pagination($startFrom, $recordPerPage, $enquiry_status, $search_text);
    public function getTotalUnchecked();
}
