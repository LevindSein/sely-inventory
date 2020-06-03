
<?php
    $role = Session::get('role');
?>


@extends( $role == 'super' ? 'admin.layout' : 'user.layout')
@section('content')
        <title>Data User</title>

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data User</h1>
          </div>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Tabel Data User</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="tableUser" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Username</th>
                      <th>Role</th>
                      <th>Hapus</th>
                      <th>Reset</th>
                    </tr>
                  </thead>
                  
                  <tbody>
                  @foreach($dataset as $d)
                  @if($d->role != "super")
                    <tr>
                      <td class="text-left">{{$d->username}}</td>
                      <td class="text-center">{{$d->role}}</td>
                      <td class="text-center">
                          <a href="{{url('hapususer',[$d->id_user])}}" class="d-none d-sm-inline-block btn btn-danger btn-sm shadow-sm"><i
                              class="fas fa- fa-sm text-white-50"></i> Hapus</a>
                      </td>
                      <td class="text-center">
                          <a href="{{url('resetpass',[$d->id_user])}}" class="d-none d-sm-inline-block btn btn-primary btn-sm shadow-sm"><i
                              class="fas fa- fa-sm text-white-50"></i> Reset</a>
                      </td>
                    </tr>
                    @endif
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