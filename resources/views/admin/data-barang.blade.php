
<?php
    $role = Session::get('role');
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
                      <th>Ditambahkan</th>
                      <th>Kode</th>
                      <th>Nama</th>
                      <th>Jenis</th>
                      <th>Masa Simpan</th>
                      <th>Satuan</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  
                  <tbody>
                  @foreach($dataset as $d)
                  <?php
                  $tgl = date("d-m-Y", strtotime($d->created_at));
                  ?>
                    <tr>
                      <td class="text-center">{{$tgl}}</td>
                      <td class="text-center">{{$d->kode_barang}}</td>
                      <td class="text-left">{{$d->nama_barang}}</td>
                      <td class="text-center">{{$d->jenis_barang}}</td>
                      <td class="text-center">{{$d->masa_simpan}} bln</td>
                      <td class="text-center">{{$d->satuan}}</td>
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