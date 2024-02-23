@extends('admin.layout')
@section('title','News')
@section('header-script')
<link rel="stylesheet" href="{{env('ASSET_URL')}}/admin/plugins/summernote/summernote-bs4.css">
<link href="{{env('ASSET_URL')}}/admin/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css" rel="stylesheet" />
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
            <div class="card card-{{Config::get('constants.THEME')}}">
              <div class="card-header">
                <h3 class="card-title">Enter News Informations</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                <form role="form" action="{{ empty($id) ? url('admin/add-news') : url('admin/edit-news')  }}" method="post" enctype="multipart/form-data" id="form">
				@csrf
                <div class="card-body">
				<div class="col-md-12">
                  <div class="form-group">
                        <input type="hidden" name="id" value="{{ $id ?? '' }}">
						<input type="hidden" name="page" value="{{ $page ?? '1' }}">
                      <label for="title">Title</label>
                      <span class="error" style="color:red;">*</span>
                      <input type="text" class="form-control" value="{{ $news_title ?? old('news_title') }}" placeholder="Enter the Title" name="news_title" id="news_title" required />
                     </div>
				</div>
			
			<div class="col-md-12">
                  <div class="form-group">
                      <label for="title">Date</label>
                      <span class="error" style="color:red;">*</span>
                      <input type="text" class="form-control date" value="{{ $news_date ?? old('news_date') }}" placeholder="Enter the Date" name="news_date" id="news_date" required />
                     </div>
				</div>
				
				<div class="col-md-12">
                  <div class="form-group">
                      <label for="title">Location</label>
                      <input type="text" class="form-control" value="{{ $news_location ?? old('news_location') }}" placeholder="Enter the Location" name="news_location" id="news_location"  />
                     </div>
				</div>
				 
                  
	<div class="col-md-12">				   
<div class=" form-group">
             <label for="userfile">Image</label><br>
            <input type="file" name="main_img" id="main_img" ><br>
           <br>
           <div id="imagePreview"></div>

             @if(!empty($main_img))
            <p class="help-block"><img src="{{ url('public/uploads/small/'.$main_img) }}"/>&nbsp;&nbsp;<a href="{{ url('admin/delete-news-image/?id='.$id.'&page='.$page) }}" role="button" onClick="return confirm('Do you want to delete this Image?')"><span class="fas fa-trash-alt"></span></a></p>
           	@endif 
				 
            </div>
                <!-- /.card-body -->
</div>

<div class="col-md-12">	
<div id="imageadd">			   
<div class=" form-group">

             <label>Sub Image(640 px * 640 px)</label><br>
            <input type="file" name="subfile[]" id="main_imgs" ><br>
           <br>
		    
           <div id="imagePreviews"></div>
		   <?php
		  // print_r($sub_image);
		   ?>
		     @if(!empty($sub_image))
			   @foreach($sub_image as $key=>$val)
			     @if($val->id!="")
                     <div class="form-group">
						 <p class="help-block"><img src="{{ url('public/uploads/small/'.$val['sub_image']) }}" />&nbsp;&nbsp;<a href="{{ url('admin/delete-news-sub-image/?edit='.$id.'&id='.$val->id.'&page='.$page) }}" role="button" onClick="return confirm('Do you want to delete this Image?')"><span class="fas fa-trash-alt"></span></a></p>
			 </div>
			    	 @endif 
			    @endforeach
					 @endif 
                     
</div>
</div>
</div>

	<div class="col-md-12">	
	<div class=" form-group">
                          <button class="btn btn-primary btn-sm btn-rounded" type="button" name="add" onClick="addmore()"><span class="fa fa-plus"></span>&nbsp;Add More</button>
                                                </div>
												</div>
												
												<div class="col-md-12">  
				<div class="form-group">
                    <label for="Title">Description</label>
				    <textarea class="textarea" placeholder="Place some text here" name="description"
                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ $description ?? old('description') }}</textarea>
				</div>  
			</div>
                <div class="card-footer">
				    @if(!empty($id))
                         <button type="submit" class="btn btn-block-sm btn-info" name="Update"><i class="fa fa-save"></i> Update</button>

                        @else
                          <button type="submit" class="btn btn-block-sm btn-danger" name="Create"><i class="fa fa-save"></i>&nbsp;Save</button>
						 @endif 

                   <a href="{{ url('admin/list-news') }}" type="button" class="btn btn-default btn-fix">Reset</a>
				</div>
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
<script src="{{env('ASSET_URL')}}/admin/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $('.date').datepicker({
        autoclose: true,
        todayHighlight: true,
        format: 'dd-mm-yyyy'
    })
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
<script>
    function addmore()
    {
        $('#imageadd').append(' <div style=" padding:10px;margin-bottom:5px;" ><div class="form-group"><label>Sub Image (640 px * 640 px)</label><br><input type="file" name="subfile[]" id="main_imgs" /><br><div id="imagePreviews"></div><br><a href="javascript:void(0)" class="btn btn-danger remove_field btn-sm btn-rounded"><span class="fa fa-minus"></span>&nbsp;Remove </a></div></div>');
    }

$('#imageadd').on("click",".remove_field", function(e){ //user click on remove text

    e.preventDefault(); $(this).parent('div').parent('div').remove(); 
});
</script>
@endsection