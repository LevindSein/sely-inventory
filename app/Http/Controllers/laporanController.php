<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LogBarang;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Redirector;
use Exception;
use Illuminate\Support\Facades\Session;

class laporanController extends Controller
{
    public function laporanBulanan(){
        if(!Session::get('login')){
            return redirect('login')->with('error','Silahkan Login Terlebih Dahulu');
        }
        else{
            if(Session::get('role') == "super"){
                $dataset = DB::table('log_barang')
                    ->select('bulan_log')
                    ->groupBy('bulan_log')
                    ->get();
                return view('admin.data-bulan',['dataset'=>$dataset]);
            }
            else{
                abort(403, 'Oops! Access Forbidden');
            }
        }
    }

    public function laporanTahunan(){
        if(!Session::get('login')){
            return redirect('login')->with('error','Silahkan Login Terlebih Dahulu');
        }
        else{
            if(Session::get('role') == "super"){
                $dataset = DB::table('log_barang')
                    ->select('tahun_log')
                    ->groupBy('tahun_log')
                    ->get();
                return view('admin.data-tahun',['dataset'=>$dataset]);
            }
            else{
                abort(403, 'Oops! Access Forbidden');
            }
        }
    }

    public function bulan($bln){
        if(!Session::get('login')){
            return redirect('login')->with('error','Silahkan Login Terlebih Dahulu');
        }
        else{
            if(Session::get('role') == "super"){
                $barangId = DB::table('log_barang')
                ->where('bulan_log',$bln)
                ->select('id_barang')
                ->groupby('id_barang')
                ->get();

                $bulan = DB::table('log_barang')
                ->where('bulan_log',$bln)
                ->first();
                return view('admin.print-bulan',['barangId'=>$barangId,'bulan'=>$bulan]);
            }
            else{
                abort(403, 'Oops! Access Forbidden');
            }
        }
    }

    public function tahun($thn){
        if(!Session::get('login')){
            return redirect('login')->with('error','Silahkan Login Terlebih Dahulu');
        }
        else{
            if(Session::get('role') == "super"){
                $barangId = DB::table('log_barang')
                ->where('tahun_log',$thn)
                ->select('id_barang')
                ->groupby('id_barang')
                ->get();

                $tahun = DB::table('log_barang')
                ->where('tahun_log',$thn)
                ->first();
                return view('admin.print-tahun',['barangId'=>$barangId,'tahun'=>$tahun]);
            }
            else{
                abort(403, 'Oops! Access Forbidden');
            }
        }
    }
}
