<?php
    $role = Session::get('role');
    $id = implode(",",$ids);
?>

@extends( $role == 'super' ? 'admin.layout' : 'user.layout')
@section('content')

       <!-- Begin Page Content -->
       <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-center">
          <h1 class="h3 mb-0 text-gray-800">Jual Stok</h1>
        </div>

        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="p-4">
            <form class="user" action="{{url('storejualstok',[$id])}}" method="POST">
              @csrf
              @foreach($dataset as $d)
                <div class="form-group">
                  {{$d->kode_barang}} {{$d->nama_barang}} {{$d->jenis_barang}} (Stok : {{$d->jumlah_barang}})
                  <input required name="stok[]" type="number" placeholder="{{$d->satuan}}" class="form-control form-control-user">
                </div>
                <div class="form-group">
                  Tujuan Penjualan
                  <input required name="tujuan[]" type="text" placeholder="PT. CV. dll" class="form-control form-control-user">
                </div>
              @endforeach
                <button type="submit" class="btn btn-primary btn-user btn-block">Jual</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    <!-- End of Main Content -->
@endsection