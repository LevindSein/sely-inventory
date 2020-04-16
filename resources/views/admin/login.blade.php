<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  
  <link rel="icon" href="{{asset('img/logo.png')}}">

  <script src="{{asset('js/animate.min.js')}}"></script>

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    @include('admin.flash-message')
                    <h1 class="h4 text-gray-900 mb-4">Login</h1>
                  </div>
                  <form class="user" action="storelogin" method="POST">
                  @csrf
                    <div class="form-group">
                      <input required type="text" class="form-control form-control-user" id="exampleInputUsername" name="username" aria-describedby="emailHelp" placeholder="Username">
                    </div>
                    <div class="form-group">
                      <input required type="password" class="form-control form-control-user" id="exampleInputPassword" name="password" placeholder="Password">
                    </div>
                    <input type="submit" value="Login" class="btn btn-primary btn-user btn-block">
                  </form>
                  <hr>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
      
      <!-- Footer -->
      <footer class="container my-auto">
          <div class="copyright text-center text-gray-100 my-auto">
            <span>Copyright &copy; Aplikasi Pengelola Tagihan</span>
          </div>
      </footer>
      <!-- End of Footer -->
    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>


  <script>
    $(document).ready(function(){
      $("#success-alert,#warning-alert,#error-alert,#info-alert").fadeTo(1700, 500).slideUp(500, function(){
         $("#success-alert,#warning-alert,#error-alert,#info-alert").slideUp(500);
       });
     });
  </script>

</body>

</html>
