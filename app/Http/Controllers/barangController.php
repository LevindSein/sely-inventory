<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barang;
use App\HapusBarang;
use App\LogBarang;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Redirector;
use Exception;
use Illuminate\Support\Facades\Session;

class barangController extends Controller
{
    public function tambahBarang(){
        if(!Session::get('login')){
            return redirect('login')->with('error','Silahkan Login Terlebih Dahulu');
        }
        else{
            if(Session::get('role') == "super"){
                return view('admin.tambah-barang');
            }
            else{
                abort(403, 'Oops! Access Forbidden');
            }
        }
    }

    public function storeBarang(Request $request){
        if(!Session::get('login')){
            return redirect('login')->with('error','Silahkan Login Terlebih Dahulu');
        }
        else{
            if(Session::get('role') == "super"){
                $random = str_shuffle('ABCDEFGHJKLMNOPQRSTUVWXYZ1234567890');
                $kode = substr($random, 0, 7);

                $kodeBarang = "KMA-".$kode;
                $namaBarang = $request->get('namaBarang');
                $jenisBarang = $request->get('jenisBarang');
                $masaSimpan = $request->get('masaSimpan');
                $satuanBarang = $request->get('satuanBarang');

                $data = new Barang([
                    'kode_barang'=>$kodeBarang,
                    'nama_barang'=>$namaBarang,
                    'jenis_barang'=>$jenisBarang,
                    'masa_simpan'=>$masaSimpan,
                    'satuan'=>$satuanBarang,
                    'jumlah_barang'=>0
                ]);
                $data->save();
                return redirect('showdatabarang')->with('success','Barang Ditambah ke Data Barang');
            }
            else{
                abort(403, 'Oops! Access Forbidden');
            }
        }
    }

    public function dataBarang(){
        if(!Session::get('login')){
            return redirect('login')->with('error','Silahkan Login Terlebih Dahulu');
        }
        else{
            if(Session::get('role') == "super"){
                $dataset = DB::table('data_barang')
                ->get();
                return view('admin.data-barang',['dataset'=>$dataset]);
            }
            else{
                abort(403, 'Oops! Access Forbidden');
            }
        }
    }

    public function hapusBarang($id){
        if(!Session::get('login')){
            return redirect('login')->with('error','Silahkan Login Terlebih Dahulu');
        }
        else{
            if(Session::get('role') == "super"){
                $dataset = DB::table('data_barang')->where('id_barang',$id)->first();
                $kodeBarang = $dataset->kode_barang;
                $namaBarang = $dataset->nama_barang;
                $jenisBarang = $dataset->jenis_barang;
                $satuanBarang = $dataset->satuan;
                $jumlahBarang = $dataset->jumlah_barang;
                $username = Session::get('username');

                $data = new HapusBarang([
                    'kode_barang'=>$kodeBarang,
                    'nama_barang'=>$namaBarang,
                    'jenis_barang'=>$jenisBarang,
                    'satuan'=>$satuanBarang,
                    'jumlah_barang'=>$jumlahBarang,
                    'session'=>$username
                ]);
                $data->save();

                DB::table('barang_baik')->where('id_barang',$id)->delete();
                DB::table('barang_warning')->where('id_barang',$id)->delete();
                DB::table('barang_exp')->where('id_barang',$id)->delete();
                DB::table('log_barang')->where('id_barang',$id)->delete();
                DB::table('data_barang')->where('id_barang',$id)->delete();

                return redirect()->route('databarang')->with('success','Barang Dihapus');
            }
            else{
                abort(403, 'Oops! Access Forbidden');
            }
        }
    }
}
