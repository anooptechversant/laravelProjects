@extends('admin.layout')
@section('title','Create Page')
@section('header-script')
<link rel="stylesheet" href="{{env('ASSET_URL')}}/admin/plugins/summernote/summernote-bs4.css">
@endsection
@section('content')
<section class="content">
      <div class="container-fluid">
	  
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
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
            <!-- Horizontal Form -->
            <div class="card card-{{Config::get('constants.THEME')}}">
              <div class="card-header">
                <h3 class="card-title">Enter Page Informations</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="{{ empty($id) ? url('admin/add-page') : url('admin/edit-page')  }}" method="post" enctype="multipart/form-data" id="form">
			   @csrf
                <div class="card-body">
				<div class="col-md-12">
                  <div class="form-group">
                         <input type="hidden" name="id" value="{{ $id ?? '' }}">
						<input type="hidden" name="page" value="{{ $page ?? '1' }}">
                      <label for="title">Title</label>
                      <span class="error" style="color:red;">*</span>
                      <input type="text" class="form-control" value="{{ $title ?? old('title') }}" placeholder="Enter the Title" name="title" id="title" required />
                     </div>
				</div>
				
			<div class="col-md-12">  
				<div class="form-group">
                    <label for="Title">Description</label>
				    <textarea class="textarea" placeholder="Place some text here" name="description" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $description ?? old('description') }}</textarea>
				</div>  
			</div>
			
				<div class="col-md-12">  
                  <div class="form-group">
                    <label for="Title">Page</label>
					 <span class="error" style="color:red;">*</span>
                    <input type="text" class="form-control" value="{{ $pagep ?? old('pagep') }}" name="pagep" id="pagep" placeholder="Enter Page Name" required >
                  </div>
				 </div>
				 
                  
	<div class="col-md-12">				   
<div class=" form-group">
             <label for="userfile">Image</label><br>
            <input type="file" name="main_img" id="main_img"  ><br>
           <br>
           <div id="imagePreview"></div>

            
			    @if(!empty($main_img))
            <p class="help-block"><img src="{{ url('public/uploads/small/'.$main_img) }}"/>&nbsp;&nbsp;<a href="{{ url('admin/delete-page-image/?id='.$id.'&page='.$page) }}" role="button" onClick="return confirm('Do you want to delete this Image?')"><span class="fas fa-trash-alt"></span></a></p>
           		 @endif 
            </div>
                <!-- /.card-body -->
</div>
                <div class="card-footer">
				    @if(!empty($id))
                         <button type="submit" class="btn btn-block-sm btn-info" name="Update"><i class="fa fa-save"></i> Update</button>

                        @else
                          <button type="submit" class="btn btn-block-sm btn-danger" name="Create"><i class="fa fa-save"></i>&nbsp;Save</button>
						 @endif 

                        <a href="{{ url('admin/list-page') }}" type="button" class="btn btn-default btn-fix">Reset</a>
				</div>
              </form>
            </div>
            <!-- /.card -->

          </div>
    
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
@endsection
@section('footer-script')
<script>
    $(function() {
        $("#main_img").on("change", function()
        {
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

            if (/^image/.test( files[0].type))
            { // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function(){ // set image data as background of div
                    $("#imagePreview").css("width", "120px");
                    $("#imagePreview").css("height", "120px");
                    $("#imagePreview").css(" background-position", "center center");
                    $("#imagePreview").css("background-size",  "cover");
                    $("#imagePreview").css("display",  "inline-block");
                    $("#imagePreview").css("background-image", "url("+this.result+")");
                }
            }
        });
    });
</script>
<script src="{{env('ASSET_URL')}}/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{env('ASSET_URL')}}/admin/plugins/summernote/summernote-bs4.min.js"></script>
<script>
  $(function () {
    // Summernote
    $('.textarea').summernote()
  })
</script>
@endsection