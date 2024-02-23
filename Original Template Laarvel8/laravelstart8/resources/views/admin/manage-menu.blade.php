@extends('admin.layout')
@section('title','Manage Menus')

@section('content')
<section class="content">
	<div class="col-sm-12" align="right">
            <a class="btn btn-rounded btn-danger" href="javascript:void(0)" onClick="click_button(1)"><i class="fa fa-save"></i> New</a>
            <a class="btn btn-rounded btn-primary" href="javascript:void(0)" onClick="click_button(2)"><i class=" fa fa-search"></i> Search</a>  
            <a class="btn btn-rounded btn-warning" href="{{ url('admin/menu-management') }}"><i class=" fa fa-sync-alt"></i> Reset</a>    
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
					
	        <div class="hide_div" style="display:{{$adddiv}}" id="adddiv">
          <div class="row" style="display: block;">	
		  <div class="col-md-12">
		  <div class="card card-{{Config::get('constants.THEME')}}">
		  		 <div class="card-header">
                <h3 class="card-title">@yield('title') Informations</h3>
              </div>
	
			
			 <form role="form" action="{{ empty($id) ? url('admin/menu-management-add') : url('admin/menu-management-edit')  }}" method="post" enctype="multipart/form-data" >
			  
			    @csrf
		<div class="row" style="display: flex;">
		<div class="card-body">
		
		
		<div class="row">
		<div class="col-sm-6 form-group">
		
                        <input type="hidden" name="id" value="{{ $id ?? '' }}">
						<input type="hidden" name="page" value="{{ $page ?? '1' }}">
                        <label for="name">Menu Name <span class="req">*</span></label>
                        <input type="text" class="form-control" value="{{ $name ?? old('name') }}" name="name" id="name"  required/>
                      </div>
					  
		<div class="col-sm-6 form-group">
                        <label for="menu_id">Parent Menu </label>
                        <select class="form-control" name="menu_id" id="menu_id">
                          <option selected="selected" value="">Select</option>
                    
                          @if(!empty($menu_data))
                          @foreach($menu_data as $row) 
                            <option value="{{ $row->id }}" @if($row->id==$menu_id) selected="selected" @endif >{{ $row->name }}</option>
                         @endforeach
                         @endif
                        </select>
                      </div>
					  
					  <div class="col-sm-6 form-group">
                        <label for="url">Url</label>
                        <input type="text" class="form-control"  name="url" id="url" value="{{ $url ?? old('url') }}"   placeholder="list-user" />
                      </div>
					  
			<div class="col-sm-6 form-group">
                        <label for="icon">Fa-Icon</label>
                        <input type="text" class="form-control" value="{{ $icon ?? old('icon') }}" name="icon" id="icon" placeholder="file-o"   />
                      </div>
					  
		<div class="col-sm-6 form-group">
                        <label for="menu_order">Menu Order <span class="req">*</span></label>
                        <input type="text" class="form-control" value="{{ $menu_order ?? old('menu_order') }}" name="menu_order" id="menu_order" required/>
                      </div>
					  
			<div class="col-sm-6 form-group">
                        <label for="menu_table">Table Name</label>
                        <input type="text" class="form-control" value="{{ $menu_table ?? old('menu_table') }}" name="menu_table" id="menu_table"   />
                      </div>
	
	<div class="col-sm-6 form-group">
                        <label for="active_file">Active files</label>
                        <input type="text" class="form-control" value="{{ $active_file ?? old('active_file') }}" name="active_file" id="active_file" placeholder="file name1,file name2 etc.." />
                      </div>
					  
			<div class="col-sm-6 form-group">
                        <label for="menu_color">Color</label>
                        <input type="text" class="form-control" value="{{ $color ?? old('color') }}" name="color" id="menu_color"   />
                      </div>
			
			<div class="col-sm-6 form-group">
                    <label for="status">Set Home</label><br />
                    
                    <label class="radio-inline"> <input type="radio" value="yes" name="set_home"  @if($set_home=='yes') checked="checked" @endif >  Yes</label>
                    <label class="radio-inline">  <input type="radio" value="no" name="set_home" @if($set_home=='no') checked="checked" @endif > No</label>
                     </div>	  
					 
		 </div> 
		 	<div class="card-body">
                       
                       @if(!empty($id))
                     
                          <button type="submit" class="btn btn-block-sm btn-info" name="update"><i class="fa fa-save"></i> Update</button>
                       @else
                      <button type="submit" name="create" class="btn btn-block-sm btn-danger"><i class="fas fa-save"></i> Save</button>
                       
                       @endif 
                       
                        <a href="{{ url('admin/menu-management') }}" type="button" class="btn btn-default btn-fix">Reset</a>
                      </div>
		  
		 </div> 	  
		</div>	  
		</form>	
		</div>  
		</div>
		</div>
		</div>
	  		<div class="hide_div" style="display:{{$srdiv}}" id="srdiv">
          <div class="row" style="display: block;" >
			 <div class="col-md-12">
  		
			<div class="card card-{{Config::get('constants.THEME')}}">
			<div class="card-header"> 
			  <h4 class="card-title">Search @yield('title')</h4>
			  </div>
			  <div class="card-body">
			     <form role="form" action="{{url('admin/menu-management')}}" method="get" enctype="multipart/form-data">
			   		<div class="row" style="display: flex;">
                      <div class="col-sm-6 form-group">
                       <label for="sr_name">Menu Name</label>
                       <input type="text" class="form-control" value="{{ $sr_name ?? old('sr_name') }}" name="sr_name" id="sr_name"  />
                     </div>
                     <div class="col-sm-6 form-group">
                       <label for="sr_url">Menu Table</label>
                        <input type="text" class="form-control" value="{{ $sr_tbl ?? old('sr_tbl') }}" name="sr_tbl" id="sr_tbl"  />
                    </div>
                    <div class="form-group sbmt-btn">
                      <button class="btn btn-danger btn-fix" type="submit" name="Search" value="sr"><span class="fa fa-search"></span>&nbsp;Search</button>

                      <a href="{{url('admin/menu-management')}}" type="button" class="btn btn-default btn-fix">Reset</a>
                    </div>
                  </div>
			   
			   </form>
			   </div>
			</div>
			</div>
			</div>
			</div>
			  
		<div class="card">
		<div class="card-header">
                <h4 class="card-title">@yield('title')</h4>
				<div class="row">
        </div>
              </div>
			  <div class="card-body table-responsive p-0">
			  <table class="table table-bordered" >
                  <thead style="background-color:#f9f9f9">                  
                    <tr>
                      <th>Menu Name</th>
                      <th>Fa-Icon</th>
					  <th>Menu Table</th>
					  <th>Menu Order</th>
					  <th>Status</th>
					  <th class="detail-col">More</th>
                      <th style="width:15%">Action</th>
                    </tr>
                  </thead>
                  <tbody>
							
          @if(!empty($results)) 
             @foreach($results as $key=>$val)
        
              <tr>
                <td>{{$val['name']}}</td>
                <td>{{$val['icon']}}</td>
                <td>{{$val['menu_table']}}</td>
                <td>{{$val['menu_order']}}</td>
                <td>
                  @if($val['status'] =='active')
                   <a href="{{url('admin/menu-management-status/?id='.$val['id'].'&st=inactive&page='.$page)}}" role="button" >
                      <span class="badge bg-success">Active</span>
                    </a>
                  @else
                    <a href="{{url('admin/menu-management-status/?id='.$val['id'].'&st=active&page='.$page)}}" role="button" >
                      <span class="badge bg-warning">Inactive</span>
                    </a>
                     @endif         
                </td>
                <td align="center">
                  <div class="action-buttons">
                    <a href="#" class="green bigger-140 show-details-btn" title="Show Details">
                      <i class="ace-icon fa fa-angle-double-down"></i>
                      <span class="sr-only">Details</span>
                    </a>
                  </div>
                </td>
                <td>

           <a href="{{ url('admin/menu-management/?edit='.$val['id'].'&page='.$page) }}" role="button" class="btn btn-sm btn btn-primary btncss" ><i class="fas fa-edit fa-sm"></i></a>

                <a href="{{ url('admin/menu-management-delete/?del='.$val['id'].'&page='.$page) }}" role="button" onClick="return confirm('Do you want to delete this Menu?')" class="btn btn-sm btn btn-danger btncss" ><i class="fas fa-trash-alt fa-sm"></i></a>
                </td>
              </tr>
              <tr class="detail-row">
                <td colspan="2">
                  <div class="col-xs-12 col-sm-12">
                    <div class="profile-info-name"><strong> Url : </strong> 
                      <span>{{$val['url']}}</span>
                    </div>
                  </div>
                </td>
                <td colspan="5">
                  <div class="col-xs-12 col-sm-12">
                    <div class="profile-info-name"> <strong> Active Files : </strong>  
                      <span>{{$val['active_file']}}</span>
                    </div>
                  </div>
                </td>
              </tr>
		
  			  @php
               $sub_results = App\Menu::get_sub_menu($val->id); 
			  @endphp
			  
              @if($sub_results)
                @foreach($sub_results as $sub_key=>$sub_val)
               
                  <tr>
                    <td>&nbsp;|-{{$sub_val->name}}</td>
                    <td>{{$sub_val->icon}}</td>
                    <td>{{$sub_val->menu_table}}</td>
                    <td>&nbsp;=>{{$sub_val->menu_order}}</td>
                    <td>
                      @if($sub_val->status =='active')
      
                        <a href="{{url('admin/menu-management-status/?id='.$sub_val->id.'&st=inactive&page='.$page)}}" role="button" > <span class="badge bg-success">Active</span>
                        </a>
             
                      @else
        
                        <a href="{{url('admin/menu-management-status/?id='.$sub_val->id.'&st=active&page='.$page)}}" role="button" ><span class="badge bg-warning">Inactive</span>
                        </a>
              
                        @endif
              
                    </td>
                    <td align="center">
                      <div class="action-buttons">
                        <a href="#" class="green bigger-140 show-details-btn" title="Show Details">
                          <i class="fa fa-angle-double-down"></i>
                          <span class="sr-only">Details </span>
                        </a>
                      </div>
                    </td>
                    <td>

                      <a href="{{url('admin/menu-management/?edit='.$sub_val->id.'&page='.$page) }}" role="button" class="btn btn-sm btn btn-primary btncss" ><i class="fas fa-edit fa-sm"></i></a>

                      <a href="{{ url('admin/menu-management-delete/?del='.$sub_val->id.'&page='.$page) }}" role="button" onClick="return confirm('Do you want to delete this Sub Menu?')" class="btn btn-sm btn btn-danger btncss" ><i class="fas fa-trash-alt fa-sm"></i></a>
                    </td>
                  </tr>
                  <tr class="detail-row">
                    <td colspan="2">
                  <div class="col-xs-12 col-sm-12">
                    <div class="profile-info-name"><strong> Url : </strong> 
                      <span>{{$sub_val->url}}</span>
                    </div>
                  </div>
                </td>
                <td colspan="5">
                  <div class="col-xs-12 col-sm-12">
                    <div class="profile-info-name"> <strong> Active Files : </strong>  
                      <span>{{$sub_val->active_file}}</span>
                    </div>
                  </div>
                </td>
                  </tr>
               
                @endforeach 
              @endif
         @endforeach
            @else
     
                    <tr>
					  			<td colspan="7"> <span id="res"><center>.........RESULT NOT FOUND.......</center></span></td>
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