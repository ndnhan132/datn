<?php

namespace App\Repositories\Enquiry;

use App\Repositories\BaseRepository;
use App\Models\Enquiry;
use App\Repositories\Post\PostRepositoryInterface;
class EnquiryRepository extends BaseRepository implements EnquiryRepositoryInterface
{
    public function getModel()
    {
        return Enquiry::class;
    }

    public function store($request)
    {
        $enquiry = new Enquiry();
        $enquiry->name = $request['name'];
        $enquiry->email = $request['email'];
        $enquiry->phone = $request['phone'];
        $enquiry->title = $request['title'];
        $enquiry->content = $request['content'];
        return $enquiry->save();
    }
}
