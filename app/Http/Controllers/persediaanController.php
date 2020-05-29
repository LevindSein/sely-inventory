<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LogBarang;
use App\Barang;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Redirector;
use Exception;
use Illuminate\Support\Facades\Session;

class persediaanController extends Controller
{
    public function tambahStok(){
        if(!Session::get('login')){
            return redirect('login')->with('error','Silahkan Login Terlebih Dahulu');
        }
        else{
            if(Session::get('role') == "super" || Session::get('role') == "user"){
                $dataset = DB::table('data_barang')
                ->get();
                return view('admin.tambah-stok',['dataset'=>$dataset]);
            }
            else{
                abort(403, 'Oops! Access Forbidden');
            }
        }
    }

    public function jualStok(){
        if(!Session::get('login')){
            return redirect('login')->with('error','Silahkan Login Terlebih Dahulu');
        }
        else{
            if(Session::get('role') == "super" || Session::get('role') == "user"){
                return view('admin.jual-stok');
            }
            else{
                abort(403, 'Oops! Access Forbidden');
            }
        }
    }
}
