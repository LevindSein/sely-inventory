<?php
    $role = Session::get('role');
?>

@extends( $role == 'super' ? 'admin.layout' : 'user.layout')
@section('content')
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Tambah Stok</h1>
          </div>

          <!-- Data LAPORAN -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="h-3 m-0 font-weight-bold text-primary">Tabel Tambah Stok</h6>
            </div>
            
            <form id="action" name="action" action="#" method="POST">
            @csrf
            <div class="card-body">
              <div class="table-responsive">
                <table class="table display table-bordered" id="tableTambah" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Pilih</th>
                      <th>Kode</th>
                      <th>Nama</th>
                      <th>Jenis</th>
                      <th>Stok</th>
                    </tr>
                  </thead>

                  <tbody>
                  @foreach($dataset as $d)
                    <tr>
                      <td class="text-center">
                      <input type="checkbox" id="checkBox" name="check[]" value="0">
                      </td>
                      <td class="text-left">{{$d->kode_barang}}</td>
                      <td class="text-left">{{$d->nama_barang}}</td>
                      <td class="text-center">{{$d->jenis_barang}}</td>
                      <td>{{$d->jumlah_barang}}</td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <div style="margin-left:35px;margin-bottom:35px;">
                <input name="button" type="submit" class="btn btn-primary" value="Tambah">
            </div>
            </form>
            <!-- End Tables -->
          </div>
          <!-- END Data LAPORAN -->
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

@endsection

@section('js')
<script>
$(document).ready(function () {
  $(
      '#tableTambah'
    ).DataTable({
      "processing": true,
      "bProcessing":true,
      "language": {
        'loadingRecords': '&nbsp;',
        'processing': '<i class="fas fa-spinner"></i>'
      },
      "scrollX": true,
      "scrollY": "400px",
      "scrollCollapse": true,
      "bSortable": false,
      "deferRender": true,
      "paging":false
    });
  });
</script>
@endsection