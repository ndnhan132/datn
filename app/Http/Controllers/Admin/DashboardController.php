<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(  )
    {
        if( $_SERVER['REQUEST_URI'] == parse_url(route('admin.dashboard.index'), PHP_URL_PATH)) {
            return view('admin.dashboard.index');
        } else {
            return redirect()->route('admin.dashboard.index');
        }
    }
}
