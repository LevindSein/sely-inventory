
<?php
    $role = Session::get('role');
?>

@extends( $role == 'super' ? 'admin.layout' : 'user.layout')
@section('content')

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Log Barang</h1>
          </div>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Tabel Log Barang</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="tableBarang" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Time</th>
                      <th>Kode</th>
                      <th>Nama</th>
                      <th>Jenis</th>
                      <th>Satuan</th>
                      <th>Jumlah</th>
                      <th>Tujuan</th>
                      <th>User</th>
                    </tr>
                  </thead>
                  
                  <tbody>
                  @foreach($dataset as $d)
                    <tr>
                      <td class="text-center"
                      <?php if($d->status==0){ ?> style="color:green;" <?php } ?>
                      <?php if($d->status==1){ ?> style="color:red;" <?php } ?>>{{$d->created_at}}</td>
                      <td class="text-center"
                      <?php if($d->status == 0) { ?> style="color:green;" <?php } ?>
                      <?php if($d->status == 1) { ?> style="color:red;" <?php } ?>>{{$d->kode_barang}}</td>
                      <td class="text-left"
                      <?php if($d->status == 0) { ?> style="color:green;" <?php } ?>
                      <?php if($d->status == 1) { ?> style="color:red;" <?php } ?>>{{$d->nama_barang}}</td>
                      <td class="text-center"
                      <?php if($d->status == 0) { ?> style="color:green;" <?php } ?>
                      <?php if($d->status == 1) { ?> style="color:red;" <?php } ?>>{{$d->jenis_barang}}</td>
                      <td class="text-center"
                      <?php if($d->status == 0) { ?> style="color:green;" <?php } ?>
                      <?php if($d->status == 1) { ?> style="color:red;" <?php } ?>>{{$d->satuan}}</td>
                      <td
                      <?php if($d->status == 0) { ?> style="color:green;" <?php } ?>
                      <?php if($d->status == 1) { ?> style="color:red;" <?php } ?>>{{$d->jumlah_log}}</td>
                      <td class="text-left"
                      <?php if($d->status == 0) { ?> style="color:green;" <?php } ?>
                      <?php if($d->status == 1) { ?> style="color:red;" <?php } ?>>{{$d->tujuan}}</td>
                      <td class="text-left"
                      <?php if($d->status == 0) { ?> style="color:green;" <?php } ?>
                      <?php if($d->status == 1) { ?> style="color:red;" <?php } ?>>{{$d->session}}</td>
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