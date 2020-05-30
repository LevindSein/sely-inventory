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

                    $bln_log = date("Y-m", time());
                    $thn_log = date("Y", time());

                    $dataLog = new LogBarang([
                        'id_barang'=>$id[$i],
                        'jumlah_log'=>$stok[$i],
                        'tujuan'=>"Stok Masuk",
                        'session'=>Session::get('username'),
                        'bulan_log'=>$bln_log,
                        'tahun_log'=>$thn_log,
                        'status'=>0
                    ]);
                    $dataLog->save();
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

                    if($stok[$i] > $barang->jumlah_barang){
                        return redirect('showjualstok')->with('error','Stok Tidak Cukup'); //input melebihi stok yang ada
                    }
                    else{ //input tercukupi
                        //get barang warning terlebih dahulu
                        $warning = DB::table('barang_warning')
                        ->select('id_warning','jumlah_warning','bulan_exp')
                        ->where('id_barang',$id[$i])
                        ->get();

                        //cek kecukupan barang warning untuk input yang dibutuhkan
                        $length = count($warning);
                        $bln_exp = "";
                        $id_warning = 0;
                        $sisa = 0;
                        $total = 0;
                        for($j=0;$j<=$length;$j++){ //ulangi sepanjang data warning
                            if($j <= $length){ //jika data warning masih ada
                                if($total < $stok[$i]){ //jika total data warning masih belum cukup
                                    if($j == $length){
                                        $sisa = $total - $stok[$i]; //sisa kurang dari nol
                                    }
                                    else if ($j < $length){
                                        $total = $total + $warning[$j]->jumlah_warning; //tambahkan terus sampai tercukupi
                                        $bln_exp = $warning[$j]->bulan_exp;
                                        $id_warning = $warning[$j]->id_warning;
                                        DB::table('barang_warning')->where('id_warning',$id_warning)->delete(); //yang sudah ditambah, record dihapus
                                    }
                                }
                                else if($total >= $stok[$i]){ //jika data warning sudah cukup
                                    $sisa = $total - $stok[$i]; //sisa lebih dari 0
                                    if($j == $length){
                                        $data = new BarangWarning([
                                            'id_warning'=>$id_warning,
                                            'id_barang'=>$id[$i],
                                            'jumlah_warning'=>$sisa,
                                            'bulan_exp'=>$bln_exp
                                        ]);
                                        $data->save(); //hasilnya dibuat record baru dengan id dan tanggal paling akhir
                                    }
                                    else if($j < $length){
                                        DB::table('barang_warning')
                                        ->where('id_warning', $id_warning)
                                        ->update([
                                            'jumlah_warning'=>$sisa
                                        ]);
                                    }
                                }
                            }
                            $bln_exp = $bln_exp;
                            $id_warning = $id_warning;
                            $sisa = $sisa;
                            // Jika belum cukup, ke data baik
                            if($j == $length && $sisa < 0){
                                //Hapus data warning yang berjumlah 0
                                DB::table('barang_warning')->where('jumlah_warning',0)->delete();

                                //kebutuhan stok
                                $butuh = $sisa * -1;
                                
                                //get data baik
                                $baik = DB::table('barang_baik')
                                ->select('id_baik','jumlah_baik','bulan_warning','exp')
                                ->where('id_barang',$id[$i])
                                ->get();

                                //cek kecukupan barang baik untuk butuh yang dibutuhkan
                                $lengthBaik = count($baik);
                                $bln_warning = "";
                                $exp = "";
                                $id_baik = 0;
                                $sisaBaik = 0;
                                $totalBaik = 0;
                                for($k=0;$k<=$lengthBaik;$k++){ //ulangi sepanjang data baik
                                    if($k <= $lengthBaik){ //jika data baik masih ada
                                        if($totalBaik < $butuh){ //jika total data baik masih belum cukup
                                            if($k == $lengthBaik){
                                                $sisaBaik = $totalBaik - $butuh; //sisa kurang dari nol
                                            }
                                            else if ($k < $lengthBaik){
                                                $totalBaik = $totalBaik + $baik[$k]->jumlah_baik; //tambahkan terus sampai tercukupi
                                                $bln_warning = $baik[$k]->bulan_warning;
                                                $exp = $baik[$k]->exp;
                                                $id_baik = $baik[$k]->id_baik;
                                                DB::table('barang_baik')->where('id_baik',$id_baik)->delete(); //yang sudah ditambah, record dihapus
                                            }
                                        }
                                        else if($totalBaik >= $butuh){ //jika data warning sudah cukup
                                            $sisaBaik = $totalBaik - $butuh; //sisa lebih dari 0
                                            if($k == $lengthBaik){
                                                $data = new BarangBaik([
                                                    'id_baik'=>$id_baik,
                                                    'id_barang'=>$id[$i],
                                                    'jumlah_baik'=>$sisaBaik,
                                                    'bulan_warning'=>$bln_warning,
                                                    'exp'=>$exp
                                                ]);
                                                $data->save(); //hasilnya dibuat record baru dengan id dan tanggal paling akhir
                                            }
                                            else if($k < $lengthBaik){
                                                DB::table('barang_baik')
                                                ->where('id_baik', $id_baik)
                                                ->update([
                                                    'jumlah_baik'=>$sisaBaik
                                                ]);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    $timezone = date_default_timezone_set('Asia/Jakarta');
                    $bln_log = date("Y-m", time());
                    $thn_log = date("Y", time());
    
                    $dataLog = new LogBarang([
                        'id_barang'=>$id[$i],
                        'jumlah_log'=>$stok[$i],
                        'tujuan'=>$tujuan[$i],
                        'session'=>Session::get('username'),
                        'bulan_log'=>$bln_log,
                        'tahun_log'=>$thn_log,
                        'status'=>1
                    ]);
                    $dataLog->save();
                }
                //Bersihkan memori barang baik
                DB::table('barang_baik')->where('jumlah_baik',0)->delete();
               
                return redirect('showdatabarang')->with('success','Stok Dijual');
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
