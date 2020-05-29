<?php
$timezone = date_default_timezone_set('Asia/Jakarta');
$now = date("d-m-Y", time());

$username = Session::get('username');
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
      <h1>Laporan Bulanan</h1>
      <div id="company" class="clearfix">
        <div>PT. Kumpul Mas Abadi</div>
        <div>Jl. Bypass Jomin<br>Perum Jomin Estate Blok B1 No.45<br>Kotabaru, Karawang</div>
        <div>(0264) 838-6513</div>
        <div>kumpulmas.ckp@gmail.com</div>
      </div>
      <div id="project">
        <div><span>BULAN LAPORAN</span><b> Disini Bulan</b></div>
        <div><span>DICETAK PADA</span> {{$now}}</div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class="service">Barang</th>
            <th class="desc">Input</th>
            <th class="desc">Output</th>
            <th>Stok</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="service">Disini Nama Jenis</td>
            <td class="desc">Disini Input</td>
            <td class="desc">Disini Output</td>
            <td class="total">Disini Input</td>
          </tr>
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