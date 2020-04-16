<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Redirector;
use Exception;
use Illuminate\Support\Facades\Session;

class dashboardController extends Controller
{
    public function dashboard(){
        return view('admin.dashboard');
    }
}