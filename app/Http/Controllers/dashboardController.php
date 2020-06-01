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
                try{
                    //PieChart
                    $pieBaik = DB::table('barang_baik')
                    ->select(DB::raw('SUM(jumlah_baik) as b_Baik'))
                    ->get();
                    $b_Baik = 0;
                    foreach($pieBaik as $b){
                        $b_Baik = $b->b_Baik;
                    }
                    $pieWarning = DB::table('barang_warning')
                    ->select(DB::raw('SUM(jumlah_warning) as b_Warning'))
                    ->get();
                    $b_Warning = 0;
                    foreach($pieWarning as $w){
                        $b_Warning = $w->b_Warning;
                    }
                    $pieExp = DB::table('barang_exp')
                    ->select(DB::raw('SUM(jumlah_exp) as b_Exp'))
                    ->get();
                    $b_Exp = 0;
                    foreach($pieExp as $e){
                        $b_Exp = $e->b_Exp;
                    }

                    return view('admin.dashboard',['b_Baik'=>$b_Baik,'b_Warning'=>$b_Warning,'b_Exp'=>$b_Exp]);
                }
                catch(\Exception $e){
                    return redirect('showdashboard')->with('error','Kesalahan Sistem');
                }
            }
            else{
                abort(403, 'Oops! Access Forbidden');
            }
        }
    }
}