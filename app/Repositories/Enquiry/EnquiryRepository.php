<?php

namespace App\Repositories\Enquiry;

use App\Repositories\BaseRepository;
use App\Models\Enquiry;
use App\Repositories\Post\PostRepositoryInterface;
use Illuminate\Support\Facades\Log;

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

    public function pagination($startFrom, $recordPerPage, $enquiry_status, $search_text)
    {
        $query = $this->model;

        if ($enquiry_status === 'CHECKED') {
            $query = $query->where('flag_is_checked', true);
        }
        elseif ($enquiry_status === 'UNCHECKED') {
            $query = $query->where('flag_is_checked', false);
        }
        if($search_text) {
            $query = $query->where(function($q) use ($search_text) {
                foreach (array('name', 'phone', 'email', 'content' ) as $f){
                    $q->orWhere($f, 'like', '%' . $search_text . '%');
                }
            });
        }
        Log::warning($query->toSql());

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
    public function getTotalUnchecked()
    {
        return $this->model->where('flag_is_checked', false)->count();
    }
}
