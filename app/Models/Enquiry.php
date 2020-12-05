<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;
    /**
     * @Author: Nhan Nguyen Dinh
     * @function: getPreviewHtml()
     * @Date: 2020-12-03 21:18:33
     * @Desc:
     * @Params1:
     * @Return:
     */
    public function getPreviewHtml()
    {
        $maxLength = 100;
        $title = trim($this->title);
        $html = "<span style='color: #000'>{$title}</span>";
        if(strlen($this->content) > 0){
            $html .= "<span class='text-muted'>&nbsp;-&nbsp;{$this->content}</span>";
        }
       return $html;
    }
}
