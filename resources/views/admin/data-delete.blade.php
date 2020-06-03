
<?php
    $role = Session::get('role');
?>

@extends( $role == 'super' ? 'admin.layout' : 'user.layout')
@section('content')
        <title>Barang Dihapus</title>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Log Delete Barang</h1>
          </div>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Tabel Log Delete</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="tableBarang" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Delete</th>
                      <th>Kode</th>
                      <th>Nama</th>
                      <th>Jenis</th>
                      <th>Satuan</th>
                      <th>Jumlah</th>
                      <th>User</th>
                    </tr>
                  </thead>
                  
                  <tbody>
                  @foreach($dataset as $d)
                  <?php
                  $tgl = date("d-m-Y", strtotime($d->created_at));
                  ?>
                    <tr>
                      <td class="text-center" style="color:red;">{{$tgl}}</td>
                      <td class="text-center">{{$d->kode_barang}}</td>
                      <td class="text-left">{{$d->nama_barang}}</td>
                      <td class="text-center">{{$d->jenis_barang}}</td>
                      <td class="text-center">{{$d->satuan}}</td>
                      <td>{{$d->jumlah_barang}}</td>
                      <td class="text-left">{{$d->session}}</td>
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