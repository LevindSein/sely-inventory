
<?php
    $role = Session::get('role');

    use Illuminate\Support\Facades\DB;
?>

@extends( $role == 'super' ? 'admin.layout' : 'user.layout')
@section('content')

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Barang</h1>
          </div>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Tabel Data Barang</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="tableBarang" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th rowspan="2">Ditambah</th>
                      <th rowspan="2">Kode</th>
                      <th rowspan="2">Nama</th>
                      <th rowspan="2">Jenis</th>
                      <th rowspan="2">Masa Simpan</th>
                      <th rowspan="2">Satuan</th>
                      <th colspan="3">Kondisi</th>
                      <th rowspan="2">Stok</th>
                      <th rowspan="2">Kedaluwarsa</th>
                      <th rowspan="2">Barang</th>
                    </tr>
                    <tr>
                      <th>Baik</th>
                      <th>Warning</th>
                      <th>Kedaluwarsa</th>
                    </tr>
                  </thead>
                  
                  <tbody>
                  @foreach($dataset as $d)
                  <?php
                  $tgl = date("d-m-Y", strtotime($d->created_at));

                  $baik = DB::table('barang_baik')
                  ->select(DB::raw('SUM(jumlah_baik) as jumBaik'))
                  ->where('id_barang',$d->id_barang)
                  ->get();
                  $jumBaik = 0;
                  foreach($baik as $b){
                    $jumBaik = $b->jumBaik;
                  }

                  $warning = DB::table('barang_warning')
                  ->select(DB::raw('SUM(jumlah_warning) as jumWarning'))
                  ->where('id_barang',$d->id_barang)
                  ->get();
                  $jumWarning = 0;
                  foreach($warning as $w){
                    $jumWarning = $w->jumWarning;
                  }

                  $exp = DB::table('barang_exp')
                  ->select(DB::raw('SUM(jumlah_exp) as jumExp'))
                  ->where('id_barang',$d->id_barang)
                  ->get();
                  $jumExp = 0;
                  foreach($exp as $e){
                    $jumExp = $e->jumExp;
                  }
                  ?>
                    <tr>
                      <td class="text-center">{{$tgl}}</td>
                      <td class="text-center">{{$d->kode_barang}}</td>
                      <td class="text-left">{{$d->nama_barang}}</td>
                      <td class="text-center">{{$d->jenis_barang}}</td>
                      <td class="text-center">{{$d->masa_simpan}} bln</td>
                      <td class="text-center">{{$d->satuan}}</td>
                      <td style="color:green;">
                      @if($jumBaik == Null)
                        0
                      @else
                        {{$jumBaik}}
                      @endif</td>
                      <td style="color:orange;">
                      @if($jumWarning == Null)
                        0
                      @else
                        {{$jumWarning}}
                      @endif</td>
                      <td style="color:red;">
                      @if($jumExp == Null)
                        0
                      @else
                        {{$jumExp}}
                      @endif</td>
                      <td>{{$d->jumlah_barang}}</td>
                      <td class="text-center">
                          <a href="{{url('resetbarang',[$d->id_barang])}}" class="d-none d-sm-inline-block btn btn-danger btn-sm shadow-sm"><i
                              class="fas fa- fa-sm text-white-50"></i>Reset</a>
                      </td>
                      <td class="text-center">
                          <a href="{{url('hapusbarang',[$d->id_barang])}}" class="d-none d-sm-inline-block btn btn-danger btn-sm shadow-sm"><i
                              class="fas fa- fa-sm text-white-50"></i>Hapus</a>
                      </td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

@endsection