@extends('admin.layout')
@section('title','News')

@section('content')
<section class="content">
 <div class="col-sm-12" align="right">
             <a class="btn btn-rounded btn-danger" href="{{ url('admin/add-news') }}" onClick="click_button(1)"><i class="fas fa-edit"></i> New</a>
            <a class="btn btn-rounded btn-primary" href="javascript:void(0)" onClick="click_button(2)"><i class=" fa fa-search"></i> Search</a>  
            <a class="btn btn-rounded btn-warning" href="{{ url('admin/list-news') }}"><i class="ace-icon fa fa-sync-alt"></i> Reset</a>    
          </div>
		  <br>
		  
		  <div class="row">
                  <div class="col-sm-12">
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
                  </div>
                </div>

 <!-- search div -->			  
<div class="hide_div" style="display:{{$srdiv}}" id="srdiv">
 <div class="row" style="display: block;">
  <div class="col-md-12">
            <!-- general form elements -->      
		<div class="card card-{{Config::get('constants.THEME')}}">
		<div class="card-header"> 
			  <h4 class="card-title">Search @yield('title')</h4>
			  </div>
			  <div class="card-body">
                                    <form role="form" action="{{url('admin/list-news')}}" method="get" enctype="multipart/form-data" >
                                        <div class="row" style="display: flex;">
                                            <div class="col-sm-12 form-group">
                                                <label>Title</label>
                                                <input class="form-control" name="un" type="text" placeholder="Title" value="{{ $un ?? old('un') }}">
                                            </div>
                                            <div class="card-body">
                                                <button class="btn btn-danger btn-fix" type="submit" name="Search" value="sr"><i class="fa fa-search"></i>Search</button>

                                                <a href="{{ url('admin/list-news') }}" type="button" class="btn btn-default btn-fix">Reset</a>
                                            </div>
                                        </div>
                                    </form>                             
                            </div>
</div>
</div> 
</div>
</div>
<div class="card ">	
<div class="card-header">
                <h4 class="card-title">@yield('title')</h4>
				<div class="row">
        </div>
              </div>		  
<div class="card-body table-responsive p-0">
                <table class="table table-bordered table-hover table-sm">
                  <thead style="background-color:#E7E7E7">                
                    <tr>
                	<th>Title</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Image</th>
                    <th>Action</th>    
                    </tr>
                  </thead>
                  <tbody>
				    @if(!empty($results)) 
                     @foreach($results as $key=>$val)
                      @php
		             $descr = base64_decode($val->description);
					   @endphp
				      <tr>
                       <td>{{ $val->news_title }}</td>
                       <td>{{ substr(strip_tags($descr),0,100)."..." }}</td>
                       <td>{{ date('d-M-Y',strtotime($val->news_date)) }}</td>
                       <td>{{ $val->news_location }}</td>
                       <td>
					    @if($val['news_image']!="")
                        <img src="{{ url('public/uploads/small/'.$val->news_image) }}">
						 @endif
						</td>
					  <td> <a href="{{ url('admin/edit-news?edit='.$val->id.'&page='.$page) }}" role="button" class="btn btn-sm btn btn-primary btncss" ><i class="fas fa-edit"></i></a>
						   <a href="{{ url('admin/delete-news?del='.$val->id.'&page='.$page) }}" onClick="return confirm('Do you want to delete this News?')" role="button" class="btn btn-sm btn btn-danger btncss" ><i class="fas fa-trash-alt"></i></a>
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


</section>
@endsection