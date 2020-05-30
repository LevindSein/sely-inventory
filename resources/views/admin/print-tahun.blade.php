<?php
$timezone = date_default_timezone_set('Asia/Jakarta');
$now = date("d-m-Y", time());

$tahun = date("Y", strtotime($tahun->tahun_log));

$username = Session::get('username');

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Redirector;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>PT. KUMPUL MAS ABADI</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}" media="all" />
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="">
      </div>
      <h1>Laporan Tahunan</h1>
      <div id="company" class="clearfix">
        <div>PT. Kumpul Mas Abadi</div>
        <div>Jl. Bypass Jomin<br>Perum Jomin Estate Blok B1 No.45<br>Kotabaru, Karawang</div>
        <div>(0264) 838-6513</div>
        <div>kumpulmas.ckp@gmail.com</div>
      </div>
      <div id="project">
        <div><span>TAHUN LAPORAN</span><b> {{$tahun}}</b></div>
        <div><span>DICETAK PADA</span> {{$now}}</div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class="service">Barang</th>
            <th class="desc" style="text-align:center;">Input</th>
            <th class="desc" style="text-align:center;">Output</th>
          </tr>
        </thead>
        <tbody>
        @for($i=0;$i < count($barangId); $i++)
        <?php
          $data = DB::table('data_barang')
          ->where('id_barang', $barangId[$i]->id_barang)
          ->first();

          $dataMasuk = DB::table('log_barang')
          ->leftJoin('data_barang','log_barang.id_barang','=','data_barang.id_barang')
          ->where([
            ['log_barang.id_barang', $barangId[$i]->id_barang],
            ['log_barang.tahun_log',$tahun],
            ['log_barang.status',0]
          ])
          ->select(DB::raw('SUM(log_barang.jumlah_log) as input'))
          ->get();
          $input = 0;
          foreach($dataMasuk as $dm){
            $input = $dm->input; 
          }

          $dataKeluar = DB::table('log_barang')
          ->leftJoin('data_barang','log_barang.id_barang','=','data_barang.id_barang')
          ->where([
            ['log_barang.id_barang', $barangId[$i]->id_barang],
            ['log_barang.tahun_log',$tahun],
            ['log_barang.status',1]
          ])
          ->select(DB::raw('SUM(log_barang.jumlah_log) as output'))
          ->get();
          $output = 0;
          foreach($dataKeluar as $dk){
            $output = $dk->output; 
          }
        ?>
          <tr>
            <td class="service">{{$data->kode_barang}}</br>{{$data->nama_barang}}</br>{{$data->jenis_barang}}</td>
            <td class="desc" style="text-align:center;">{{number_format($input)}} {{$data->satuan}}</td>
            <td class="desc" style="text-align:center;">{{number_format($output)}} {{$data->satuan}}</td>
          </tr>
        @endfor
        </tbody>
      </table>
      <div id="notices">
        <div>TERTANDA:</div>
        <div class="notice"><b>{{$username}}</b></div>
      </div>
    </main>
    <script type="text/javascript">
      window.print();
    </script>
  </body>
</html>