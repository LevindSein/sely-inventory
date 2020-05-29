<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Redirector;
use Exception;
use Illuminate\Support\Facades\Session;
use DateTime;
use DateInterval;
use App\BarangWarning;
use App\BarangBaik;
use App\BarangExp;

class dashboardController extends Controller
{
    public function dashboard(){
        if(!Session::get('login')){
            return redirect('login')->with('error','Silahkan Login Terlebih Dahulu');
        }
        else{
            if(Session::get('role') == "super" || Session::get('role') == "user"){
                return view('admin.dashboard');
            }
            else{
                abort(403, 'Oops! Access Forbidden');
            }
        }
    }
}