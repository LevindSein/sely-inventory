<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barang;
use App\HapusBarang;
use App\BarangExp;
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
                //Jumlah Stok
                $id = DB::table('data_barang')
                ->select('id_barang')
                ->get();
                $lenght = $id->count();
                
                $totalB=array();
                $totalW=array();
                $totalE=array();
                for($i=0;$i<$lenght;$i++){
                    $barangBaik = DB::table('barang_baik')
                    ->where('id_barang',$id[$i]->id_barang)
                    ->select('jumlah_baik')
                    ->get();
                    $tb = 0;
                    foreach($barangBaik as $b){
                        $tb = $tb + $b->jumlah_baik;
                    }
                    $totalB[$i] = $tb;

                    $barangWarning = DB::table('barang_warning')
                    ->where('id_barang',$id[$i]->id_barang)
                    ->select('jumlah_warning')
                    ->get(); 
                    $tw = 0;
                    foreach($barangWarning as $w){
                        $tw = $tw + $w->jumlah_warning;
                    }
                    $totalW[$i] = $tw;
                    
                    $barangExp = DB::table('barang_exp')
                    ->where('id_barang',$id[$i]->id_barang)
                    ->select('jumlah_exp')
                    ->get(); 
                    $te = 0;
                    foreach($barangExp as $e){
                        $te = $te + $e->jumlah_exp;
                    }
                    $totalE[$i] = $te;
                }

                for($j=0;$j<$lenght;$j++){
                    $total = $totalB[$j] + $totalW[$j] + $totalE[$j]; 
                    DB::table('data_barang')
                    ->where('id_barang', $id[$j]->id_barang)
                    ->update([
                        'jumlah_barang'=>$total
                    ]);
                }

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

    public function resetBarang($id){
        if(!Session::get('login')){
            return redirect('login')->with('error','Silahkan Login Terlebih Dahulu');
        }
        else{
            if(Session::get('role') == "super"){
                
                DB::table('barang_exp')->where('id_barang',$id)->delete();
                $data = new BarangExp([
                    'id_barang'=>$id,
                    'jumlah_exp'=>0,
                ]);
                $data->save();

                return redirect()->route('databarang')->with('success','Barang Kedaluwarsa di Reset');
            }
            else{
                abort(403, 'Oops! Access Forbidden');
            }
        }
    }
}
