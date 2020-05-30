<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HapusBarang;
use App\LogBarang;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Redirector;
use Exception;
use Illuminate\Support\Facades\Session;

class logController extends Controller
{
    public function logStok(){
        if(!Session::get('login')){
            return redirect('login')->with('error','Silahkan Login Terlebih Dahulu');
        }
        else{
            if(Session::get('role') == "super"){
                $dataset = DB::table('log_barang')
                ->leftJoin('data_barang','log_barang.id_barang','=','data_barang.id_barang')
                ->select('data_barang.kode_barang','data_barang.nama_barang','data_barang.jenis_barang',
                         'data_barang.satuan','log_barang.jumlah_log','log_barang.session','log_barang.status',
                         'log_barang.tujuan','log_barang.created_at')
                ->get();
                return view('admin.data-log',['dataset'=>$dataset]);
            }
            else{
                abort(403, 'Oops! Access Forbidden');
            }
        }
    }

    public function logDelete(){
        if(!Session::get('login')){
            return redirect('login')->with('error','Silahkan Login Terlebih Dahulu');
        }
        else{
            if(Session::get('role') == "super"){
                $dataset = DB::table('delete_barang')
                ->get();
                return view('admin.data-delete',['dataset'=>$dataset]);
            }
            else{
                abort(403, 'Oops! Access Forbidden');
            }
        }
    }
}
