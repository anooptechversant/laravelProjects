<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ $title }} | {{ env('APP_NAME') }}</title>
 <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{env('ASSET_URL')}}/admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{env('ASSET_URL')}}/admin/dist/css/adminlte.min.css">
 
    <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{env('ASSET_URL')}}/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  
    <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="{{env('ASSET_URL')}}/admin/dist/css/developer.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{env('ASSET_URL')}}/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
  <b>Admin</b>{{env('APP_NAME')}}
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>
	  
		@if ($message = Session::get('success'))
		<div class="alert alert-success alert-block">
		   <button type="button" class="close" data-dismiss="alert">&times;</button>    
			<strong>{{ $message }}</strong>
		</div>
		@endif
		
		@if ($message = Session::get('errormsg'))
		<div class="alert alert-danger alert-block">
			<button type="button" class="close" data-dismiss="alert">&times;</button>    
			<strong>{{ $message }}</strong>
		</div>
		@endif

		@if($errors->any())
		<div class="alert alert-danger alert-dismissable">
					<i class="fa fa-ban"></i>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<b>Please fix the following errors:</b> <br>
		   @foreach ($errors->all() as $error)
			  <div>{{ $error }}</div>
		  @endforeach
		  </div>
		@endif
  
      <form action="{{url('admin/login')}}" method="post">
	   @csrf
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username"  name="username" required  maxlength="20" value="{{ $username ?? old('username') }}">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" required  maxlength="20" value="{{  $password ?? old('password') }}">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
                <input type="checkbox" name="remember_me" id="remember" value="yes"  @php if($rem=='yes') { echo 'checked="checked"'; } @endphp  />
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
		     <button type="submit" class="btn btn-primary btn-block" name="Login">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
<!-- jQuery -->
<script src="{{env('ASSET_URL')}}/admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="{{env('ASSET_URL')}}/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{env('ASSET_URL')}}/admin/dist/js/adminlte.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{env('ASSET_URL')}}/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<!-- bs-custom-file-input -->
<script src="{{env('ASSET_URL')}}/admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
</body>
</html>
