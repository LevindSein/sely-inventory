<?php
    $role = Session::get('role');
?>


@extends( $role == 'super' ? 'admin.layout' : 'user.layout')
@section('content')

       <title>Tambah User</title>
       <!-- Begin Page Content -->
       <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-center">
          <h1 class="h3 mb-0 text-gray-800">Tambah User</h1>
        </div>

        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="p-4">
              <form class="user" action="{{url('storeuser')}}" method="POST">
              @csrf
                <div class="form-group">
                  <input type="text" required class="form-control form-control-user" id="exampleInputNamaUser" name="username" placeholder="Nama User">
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block">Tambah</button>
              </form>
              
            </div>
          </div>
        </div>
      </div>

    <!-- End of Main Content -->

@endsection

@section('js')
<script>
var field = document.querySelector('[name="username"]');

field.addEventListener('keypress', function ( event ) {  
   var key = event.keyCode;
    if (key === 32) {
      event.preventDefault();
    }
});
</script>
@endsection