@extends('admin.layout')
@section('title','Admin Users')

@section('content')
<section class="content">
	<div class="col-sm-12" align="right">
            <a class="btn btn-rounded btn-danger" href="javascript:void(0)" onClick="click_button(1)"><i class="fas fa-edit"></i> New</a>
            <a class="btn btn-rounded btn-primary" href="javascript:void(0)" onClick="click_button(2)"><i class=" fa fa-search"></i> Search</a>  
            <a class="btn btn-rounded btn-warning" href="{{ url('admin/list-admin') }}"><i class="ace-icon fa fa-sync-alt"></i> Reset</a>    
          </div>
		  <br>
    <div class="container-fluid">
	 <div class="row-sm-12">
		
   
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
					
		
			  <!-- search div -->
		<div class="hide_div" style="display:{{$srdiv}}" id="srdiv">
          <div class="row" style="display: block;" >
			 <div class="col-md-12">
            <!-- general form elements -->
			<div class="card card-{{Config::get('constants.THEME')}}">
              <div class="card-header"> 
			  <h4 class="card-title">Search @yield('title')</h4>
			  </div>
			  <div class="card-body">
                  <form role="form" action="{{url('admin/list-admin')}}" method="get" enctype="multipart/form-data" >
				      @csrf
                    <div class="row" style="display: flex;">
                      <div class="col-sm-6 form-group">
                       <label for="username">Username</label>
                       <input type="text" class="form-control" value="{{ $un ?? old('un') }}" name="un" id="un"  />
                     </div>
                     <div class="col-sm-6 form-group">
                       <label for="user_type">User Type</label>
                       <select class="form-control" name="ut" id="ut" >
                        <option value="" selected="selected">Select</option>
                        <option value="staff" @if($ut=='staff') selected="selected"  @endif >Staff</option>
                        <option value="admin" @if($ut=='admin') selected="selected"  @endif >Admin</option>
                      </select>
                    </div>
                    <div class="card-body">
                      <button class="btn btn-block-sm btn-danger" type="submit" name="Search" value="sr"> <i class="fa fa-search"></i>&nbsp;Search</button>

                      <a href="{{ url('admin/list-admin') }}" type="button" class="btn btn-default btn-fix">Reset</a>
                    </div>
                  </div>
                </form>
              </div>
			  
			  </div>
			  </div>
			  </div>
			  </div>
	
		<!-- End of search div -->
			
		<div class="hide_div" style="display:{{$adddiv}}" id="adddiv">
		<div class="row" style="display: block;">
		 <div class="col-md-12">
		 <div class="card card-{{Config::get('constants.THEME')}}">
		 <div class="card-header">
                <h3 class="card-title">@yield('title') Informations</h3>
              </div>
		 			   <form role="form" action="{{ empty($id) ? url('admin/list-admin-add') : url('admin/list-admin-edit')  }}" method="post" enctype="multipart/form-data" >
    @csrf
	<div class="card-body">
	<div class="row">
		<div class="col-md-4">
				 	<div class="form-group"> 
                        <input type="hidden" name="id" value="{{ $id ?? '' }}">
						<input type="hidden" name="page" value="{{ $page ?? '1' }}">
						
                        <label for="username">Username <span class="error" style="color:red;">*</span></label>
                        <input type="text" class="form-control" value="{{ $username ?? old('username') }}" name="username" id="username"  required />
						</div>
                      </div>
	
	     				  
				<div class="col-md-4">
				<div class="form-group"> 
                        <label for="password">Password <span class="error" style="color:red;">*</span></label>
                        <input type="password" class="form-control"  name="password" id="password" value="{{ $password ?? old('password') }}"   maxlength="20" required />
						</div>
                      </div>  
				  
				  				
                  <div class="col-md-4">
				  <div class="form-group"> 
                        <label for="user_type">User Type <span class="error" style="color:red;">*</span></label>
                        <select class="form-control" name="user_type" id="user_type"  required >
                          <option value="">Select</option>
                          <option value="staff" @if($user_type=='staff' or old($user_type)=='staff') selected="selected" @endif >Staff</option>
                          <option value="admin" @if($user_type=='admin'  or old($user_type)=='admin') selected="selected" @endif >Admin</option>
                        </select>
                      </div>
					  </div>
                  </div>
				   </div>

                <!-- /.card-body -->

                		<div class="card-footer center">
                           @if(!empty($id))
                         <button type="submit" class="btn btn-block-sm btn-info" name="Update"><i class="fa fa-save"></i> Update</button>

                        @else
                          <button type="submit" class="btn btn-block-sm btn-danger" name="Create"><i class="fa fa-save"></i>&nbsp;Save</button>
						 @endif 

                        <a href="{{ url('admin/list-admin') }}" type="button" class="btn btn-default btn-fix">Reset</a>
 </div>
			   

</form>
		 </div>
		</div>
		</div>
		 </div>
		 
   <div class="card">	
	<div class="card-header">
                <h4 class="card-title">@yield('title')</h4>
              </div>
	<div class="card-body table-responsive p-0">
	         
                <table class="table table-bordered table-hover table-sm">
                  <thead style="background-color:#f9f9f9">                  
                    <tr>        
                      <th>Username</th>
                      <th>Usertype</th>
					  <th>Status</th>
					  <th>Password</th>
                      <th style="width:18%">Action</th>
                    </tr>
                  </thead>
                  <tbody>
				  @if(!empty($results)) 
                     @foreach($results as $key=>$val)
                      @php
                      $password = decrypt_password($val->password);
					  @endphp 
                     <tr>
                      <td>{{$val->username}}</td>
                      <td>
                        {{$val->user_type}}
                      </td>
                      <td> 
					     @if($val->status =='active')
                            <a href="{{url('admin/list-admin-status/?id='.$val['id'].'&st=inactive&page='.$page)}}" role="button" >
                              <span class="badge bg-success">Active</span>
                            </a>
                             @else
                            <a href="{{url('admin/list-admin-status/?id='.$val['id'].'&st=active&page='.$page)}}" role="button" >
                              <span class="badge bg-warning">Inactive</span>
                            </a>
                            @endif         
					  </td>
					  <td align="center">
                          <div class="action-buttons">
                            <a href="#" class="green bigger-140 show-details-btn" title="Show Details">
                              <i class="fa fa-angle-double-down"></i>
                              <span class="sr-only">Details</span>
                            </a>
                          </div>
					 </td>
					  <td>
                          @if($val->status =='active')
					  
					  <a href="{{url('admin/list-admin-status/?id='.$val['id'].'&st=inactive&page='.$page)}}" role="button" class="btn btn-sm btn btn-success btncss" ><i class="fa fa-unlock"></i></a>
					    @else
						  
						  <a href="{{url('admin/list-admin-status/?id='.$val['id'].'&st=active&page='.$page)}}" role="button" class="btn btn-sm btn-danger btn-rounded" ><i class="fa fa-lock"></i></a>
                            @endif        
						 
						   <a href="{{url('admin/list-admin/?edit='.$val->id.'&page='.$page) }}" role="button" class="btn btn-sm btn btn-primary btncss" ><i class="fas fa-edit"></i></a>
						   
						   <a href="{{ url('admin/list-admin-delete/?del='.$val->id.'&page='.$page) }}" onClick="return confirm('Do you want to delete this User?')"role="button" class="btn btn-sm btn btn-danger btncss" ><i class="fas fa-trash-alt"></i></a>
						   
					 </td>
                    </tr>
					 <tr class="detail-row">
                        <td colspan="5">
                          <div class="col-xs-12 col-sm-12">
                            <div class="profile-info-name"> Password : 
                            <span>{{$password}}</span>
                            </div>
                          </div>
                        </td>
                      </tr>
                     @endforeach
           			 @else
						<tr>
					  		<td colspan="5"> <span id="res"><center>.........RESULT NOT FOUND.......</center></span></td>
					  </tr>
                     @endif
                  </tbody>
                </table>
              </div>
	<div class="card-footer clearfix">
	@if(!empty($results)) 

		  {{ $results->appends(Request::all())->links('vendor.pagination.bootstrap-4')  }}
		 @endif
	  </div>
              
	</div>
<!--- row -->
	</div>
	</div>
</section>
@endsection
@section('footer-script')	
 <script type="text/javascript">
    jQuery(function($) {

      /***************/
      $('.show-details-btn').on('click', function(e) {
        e.preventDefault();
        $(this).closest('tr').next().toggleClass('open');
                //$(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
              });
      /***************/


    });
  </script>
@endsection