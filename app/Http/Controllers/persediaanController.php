<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Redirector;
use Exception;
use Illuminate\Support\Facades\Session;
use DateTime;
use DateInterval;
use App\LogBarang;
use App\Barang;
use App\BarangWarning;
use App\BarangBaik;
use App\BarangExp;

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

    public function tambah(Request $request){
        if(!Session::get('login')){
            return redirect('login')->with('error','Silahkan Login Terlebih Dahulu');
        }
        else{
            if(Session::get('role') == "super" || Session::get('role') == "user"){
                if($request->get('check') != null){
                    $ids = $request->get('check');
                    $dataset = DB::table('data_barang')
                    ->whereIn('id_barang',$ids)
                    ->get();
                }
                else{
                    $dataset = DB::table('data_barang')
                    ->get();

                    $i=0;
                    foreach($dataset as $d){
                        $ids[$i] = $d->id_barang;
                        $i++;
                    }
                }
                return view('admin.form-tambah',['dataset'=>$dataset,'ids'=>$ids]);
            }
            else{
                abort(403, 'Oops! Access Forbidden');
            }
        }
    }

    public function storeTambah(Request $request,$ids){
        if(!Session::get('login')){
            return redirect('login')->with('error','Silahkan Login Terlebih Dahulu');
        }
        else{
            if(Session::get('role') == "super" || Session::get('role') == "user"){
                $stok = $request->get('stok');
                $id = explode(",",$ids);
                $timezone = date_default_timezone_set('Asia/Jakarta');
                $now = date("Y-m-d", time());

                for($i=0;$i<count($id);$i++){
                    $simpan = DB::table('data_barang')
                    ->select('masa_simpan')
                    ->where('id_barang',$id[$i])
                    ->first();

                    $bln = $simpan->masa_simpan;
                    $nMonths = $bln - round($bln * 30 / 100);
                    $warning = $this->endCycle($now, $nMonths);
                    $expired = $this->endCycle($now, $bln);

                    $data = new BarangBaik([
                        'id_barang'=>$id[$i],
                        'jumlah_baik'=>$stok[$i],
                        'bulan_warning'=>$warning,
                        'exp'=>$expired
                    ]);
                    $data->save();
                }

                return redirect('showdatabarang')->with('success','Stok Ditambah');
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
                $dataset = DB::table('data_barang')
                ->get();
                return view('admin.jual-stok',['dataset'=>$dataset]);
            }
            else{
                abort(403, 'Oops! Access Forbidden');
            }
        }
    }

    public function jual(Request $request){
        if(!Session::get('login')){
            return redirect('login')->with('error','Silahkan Login Terlebih Dahulu');
        }
        else{
            if(Session::get('role') == "super" || Session::get('role') == "user"){
                if($request->get('check') != null){
                    $ids = $request->get('check');
                    $dataset = DB::table('data_barang')
                    ->whereIn('id_barang',$ids)
                    ->get();
                }
                else{
                    $dataset = DB::table('data_barang')
                    ->get();

                    $i=0;
                    foreach($dataset as $d){
                        $ids[$i] = $d->id_barang;
                        $i++;
                    }
                }
                return view('admin.form-jual',['dataset'=>$dataset,'ids'=>$ids]);
            }
            else{
                abort(403, 'Oops! Access Forbidden');
            }
        }
    }

    public function storeJual(Request $request,$ids){
        if(!Session::get('login')){
            return redirect('login')->with('error','Silahkan Login Terlebih Dahulu');
        }
        else{
            if(Session::get('role') == "super" || Session::get('role') == "user"){
                $stok = $request->get('stok');
                $tujuan = $request->get('tujuan');
                $id = explode(",",$ids);

                
                for($i=0;$i<count($id);$i++){
                    $barang = DB::table('data_barang')
                    ->select('jumlah_barang')
                    ->where('id_barang',$id[$i])
                    ->first();

                    if($stok[$i] >= $barang->jumlah_barang){
                        return redirect('jual/stok')->with('error','Stok Tidak Cukup');
                    }
                    else{
                        echo "cukup";
                        // $warning = DB::table('barang_warning')
                        // ->select('id_warning','jumlah_warning')
                        // ->where('id_barang',$id[$i])
                        // ->get();

                        // $j = 0;
                        // foreach($warning as $war){
                        // }
                    }
                }

                // return redirect('showdatabarang')->with('success','Stok Dijual');
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
        $dateReturned = $newDate->format('Y-m-01'); 

        return $dateReturned;
    }
}
