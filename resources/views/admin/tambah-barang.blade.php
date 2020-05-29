<?php
    $role = Session::get('role');
?>

@extends( $role == 'super' ? 'admin.layout' : 'user.layout')
@section('content')
       <!-- Begin Page Content -->
  
       <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-center">
          <h1 class="h3 mb-0 text-gray-800">Tambah Barang</h1>
        </div>

        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="p-4">
              <form class="user" action="{{url('storebarang')}}" method="POST">
              @csrf
                <div class="form-group">
                  Nama Barang
                  <input required type="text" name="namaBarang" class="form-control form-control-user" id="namaBarangId" placeholder="Merek Barang atau Deskripsi Barang">
                </div>
                <div class="form-group">
                  <label for="sel1">Jenis Barang</label>
                  <select class="form-control" name="jenisBarang" id="jenisBarangId">
                    <option disabled selected hidden>Pilih Jenis</option>
                    <option value="Masker">Masker</option>
                    <option value="Sarung Tangan">Sarung Tangan</option>
                    <option value="Majun">Majun</option>
                    <option value="Alat Tulis Kerja">Alat Tulis Kerja</option>
                    <option value="Alat Pengaman Diri">Alat Pengaman Diri</option>
                    <option value="Alat Kerja">Alat Kerja</option>
                  </select>
                </div>
                <div class="form-group">
                  Masa Simpan
                  <input type="number" min="0" name="masaSimpan" class="form-control form-control-user" id="masaSimpanId" placeholder="Bulan">
                </div>
                <div class="form-group">
                  <label for="sel1">Satuan Barang</label>
                  <select class="form-control" name="satuanBarang" id="satuanBarangId">
                    <option disabled selected hidden>Pilih Satuan</option>
                    <option value="PCS">Pcs</option>
                    <option value="LSN">Lusin</option>
                    <option value="KODI">Kodi</option>
                    <option value="KG">Kilogram</option>
                    <option value="BOX">Box</option>
                    <option value="ROLL">Roll</option>
                    <option value="CUSTOM">Custom</option>
                  </select>
                </div>
                <input type="submit" value="Tambah Barang" class="btn btn-primary btn-user btn-block">
              </form>      
            </div>
          </div>
        </div>
      </div>
    <!-- End of Main Content -->
@endsection