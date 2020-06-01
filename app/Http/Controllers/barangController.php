<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTime;
use DateInterval;
use App\LogBarang;
use App\Barang;
use App\BarangWarning;
use App\BarangBaik;
use App\BarangExp;
use App\HapusBarang;
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
                try{
                    return view('admin.tambah-barang');
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

    public function storeBarang(Request $request){
        if(!Session::get('login')){
            return redirect('login')->with('error','Silahkan Login Terlebih Dahulu');
        }
        else{
            if(Session::get('role') == "super"){
                try{
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
                    return redirect('showdatabarang')->with('success','Barang Ditambah');
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

    public function dataBarang(){
        if(!Session::get('login')){
            return redirect('login')->with('error','Silahkan Login Terlebih Dahulu');
        }
        else{
            if(Session::get('role') == "super" || Session::get('role') == "user"){
                try{
                    //Cek Barang Warning
                    $timezone = date_default_timezone_set('Asia/Jakarta');
                    $now = date("Y-m-d", time());

                    $warning = DB::table('barang_baik')
                    ->select('id_baik','id_barang','jumlah_baik','bulan_warning','exp')
                    ->get();

                    $expired = DB::table('barang_warning')
                    ->select('id_warning','id_barang','jumlah_warning','bulan_exp')
                    ->get();

                    foreach($warning as $war){
                        if($now >= $war->bulan_warning && $now < $war->exp){
                            $data = new BarangWarning([
                                'id_barang'=>$war->id_barang,
                                'jumlah_warning'=>$war->jumlah_baik,
                                'bulan_exp'=>$war->exp
                            ]);
                            $data->save();
            
                            DB::table('barang_baik')->where('id_baik',$war->id_baik)->delete();
                        }
                    }

                    foreach($expired as $ex){
                        if($now >= $ex->bulan_exp){
                            $data = new BarangExp([
                                'id_barang'=>$ex->id_barang,
                                'jumlah_exp'=>$ex->jumlah_warning
                            ]);
                            $data->save();
            
                            DB::table('barang_warning')->where('id_warning',$ex->id_warning)->delete();
                        }
                    }

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
                        $total = $totalB[$j] + $totalW[$j]; 
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
                catch(\Exception $e){
                    return redirect('showdashboard')->with('error','Kesalahan Sistem');
                }
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
                try{
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
                catch(\Exception $e){
                    return redirect('showdashboard')->with('error','Kesalahan Sistem');
                }
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
                try{
                    DB::table('barang_exp')->where('id_barang',$id)->delete();
                    $data = new BarangExp([
                        'id_barang'=>$id,
                        'jumlah_exp'=>0,
                    ]);
                    $data->save();

                    return redirect()->route('databarang')->with('success','Barang Kedaluwarsa di Reset');
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

    public function add_months($months, DateTime $dateObject) 
    {
        $next = new DateTime($dateObject->format('Y-m-d'));
        $next->modify('last day of +'.$months.' month');

        if($dateObject->format('d') > $next->format('d')) {
            return $dateObject->diff($next);
        } else {
            return new DateInterval('P'.$months.'M');
        }
    }

    public function endCycle($d1, $months)
    {
        $date = new DateTime($d1);
        $newDate = $date->add($this->add_months($months, $date));
        $dateReturned = $newDate->format('Y-m-d'); 

        return $dateReturned;
    }
}
