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
    public function logInput(){
        if(!Session::get('login')){
            return redirect('login')->with('error','Silahkan Login Terlebih Dahulu');
        }
        else{
            if(Session::get('role') == "super"){
                $dataset = DB::table('log_barang')
                ->leftJoin('data_barang','log_barang.id_barang','=','data_barang.id_barang')
                ->select('data_barang.kode_barang','data_barang.nama_barang','data_barang.jenis_barang',
                         'data_barang.satuan','log_barang.jumlah_log','log_barang.session','log_barang.created_at')
                ->where('status',0)
                ->get();
                return view('admin.data-input',['dataset'=>$dataset]);
            }
            else{
                abort(403, 'Oops! Access Forbidden');
            }
        }
    }

    public function logOutput(){
        if(!Session::get('login')){
            return redirect('login')->with('error','Silahkan Login Terlebih Dahulu');
        }
        else{
            if(Session::get('role') == "super"){
                $dataset = DB::table('log_barang')
                ->leftJoin('data_barang','log_barang.id_barang','=','data_barang.id_barang')
                ->select('data_barang.kode_barang','data_barang.nama_barang','data_barang.jenis_barang',
                         'data_barang.satuan','log_barang.jumlah_log','log_barang.tujuan',
                         'log_barang.session','log_barang.created_at')
                ->where('status',1)
                ->get();
                return view('admin.data-output',['dataset'=>$dataset]);
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
