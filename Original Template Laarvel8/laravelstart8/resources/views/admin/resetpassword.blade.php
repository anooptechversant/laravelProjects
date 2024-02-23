@extends('admin.layout')
@section('title','Reset Password')

@section('content')
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-{{Config::get('constants.THEME')}}">
              <div class="card-header">
                <h3 class="card-title">Enter Password Informations</h3>
              </div>
				
              <form class="form-horizontal" action="{{url('admin/reset-password')}}" method="post">
			  @csrf
                <div class="card-body">
				
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
                  <div class="input-group mb-3">
				    <label for="inputPassword3" class="col-sm-2 col-form-label">Old Password</label>
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                  </div>
                  <input type="password" class="form-control" name="old_pwd" placeholder="Old Password" value="{{ old('old_pwd') }}" required >
                </div>
				
                  <div class="input-group mb-3">
				  <label for="inputPassword3" class="col-sm-2 col-form-label">New Password</label>
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                  </div>
                  <input type="password" class="form-control" placeholder="New Password" name="new_pwd"  value="{{ old('new_pwd') }}" required>
                </div>
				
				<div class="input-group mb-3">
				  <label for="inputPassword3" class="col-sm-2 col-form-label">Confirm Password</label>
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                  </div>
                  <input type="password" class="form-control" placeholder="Confirm Password" name="conf_password"  value="{{ old('conf_password') }}" required >
                </div>
				
                  
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-{{Config::get('constants.THEME_BTN')}}"><i class="fas fa-thumbs-up"></i> Change</button>
                  <button type="reset" class="btn btn-default float-right">Cancel</button>
                </div>
              </form>
            </div>
          </div>
    
        </div>
      </div>
    </section>	
@endsection