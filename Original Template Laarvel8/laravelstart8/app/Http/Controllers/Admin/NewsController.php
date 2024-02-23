<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\News;
use App\NewsImage;
use Image;
use Config;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['srdiv'] 			= "none";

		$data['page']			= ($request->input('page')) ? $request->input('page') : 1;
		

	       $query = News::orderBy('id', 'desc');
		
			 if( !empty($request->input('un')) )
			  {
				 $un = $request->input('un');
				 $data['un'] 	= $un;
				 $query->where('news_title','like','%'.$un.'%');
				 $data['srdiv'] = "block";
			  }
			  
			  
		$results = $query->paginate(Config::get('constants.PG_LIMIT_AD'));
		
		return view('admin.list-news')->with($data)->with('results',$results);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      
		$method = $request->method();
		if($method=='POST')
		{
	
		  $this->validate($request, [

            'news_date' => 'required|date_format:d-m-Y',
			'news_title' => 'required',
            'main_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
		
			
				 
		 $news_title 	    = $request->news_title;
		 $description 		= base64_encode($request->description);
		 $news_date  		= date('Y-m-d',strtotime($request->news_date));
		 $news_location 	= $request->news_location;

			$main_img ="";
			$image = $request->file('main_img');
		    if($image!="")
			{
						
				$main_img= file_extesion($image);
		
				$destinationPath = public_path('/uploads/orginal');
				$image->move($destinationPath, $main_img);
				
				//Resize image here
				$orginal_path = $destinationPath."/".$main_img;
				
				$thumbnailpath = public_path('/uploads/large/'.$main_img);
				$img = Image::make($orginal_path)->resize(800, 800, function($constraint) {
					$constraint->aspectRatio();
				})->save($thumbnailpath);
				
				$thumbnailpath = public_path('/uploads/medium/'.$main_img);
				$img = Image::make($orginal_path)->resize(250, 250, function($constraint) {
					$constraint->aspectRatio();
				})->save($thumbnailpath);
				
						
				$thumbnailpath = public_path('/uploads/small/'.$main_img);
				$img = Image::make($orginal_path)->fit(150, 150, function($constraint) {
				 $constraint->aspectRatio();
				})->save($thumbnailpath);
		  }
				
			 $model = new News;
			 $model->news_title		= $news_title;
			 $model->description 	= $description;
			 $model->news_date 		= $news_date;
			 $model->news_location 	= $news_location;
			 $model->news_image 	= $main_img;

 
			 $model->save();
			 $insert_id  = $model->id;
			 
			 
		    if($request->hasfile('subfile'))
			{
						
				foreach($request->file('subfile') as $sub_image)
				{
				
				$main_img = file_extesion($sub_image);
		
				$destinationPath = public_path('/uploads/orginal');
				$sub_image->move($destinationPath, $main_img);
				
				//Resize image here
				$orginal_path = $destinationPath."/".$main_img;
				
				$thumbnailpath = public_path('/uploads/large/'.$main_img);
				$img = Image::make($orginal_path)->resize(800, 800, function($constraint) {
					$constraint->aspectRatio();
				})->save($thumbnailpath);
				
				$thumbnailpath = public_path('/uploads/medium/'.$main_img);
				$img = Image::make($orginal_path)->resize(250, 250, function($constraint) {
					$constraint->aspectRatio();
				})->save($thumbnailpath);
				
						
				$thumbnailpath = public_path('/uploads/small/'.$main_img);
				$img = Image::make($orginal_path)->fit(150, 150, function($constraint) {
				 $constraint->aspectRatio();
				})->save($thumbnailpath);
				
				 
				 $modelsub = new NewsImage; 
				 
				 $modelsub->sub_image  	= $main_img;
				 $modelsub->news_id  	= $insert_id;
				 $modelsub->save();

				
			  }
		   }
			
			
			 session()->flash('success', 'News Created Successfully');
			 return redirect('admin/add-news');

		
		}
		
		return view('admin.add-news');

		 
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        
	
		$page	= ($request->input('page')) ? $request->input('page') : 1;
		
		$data['page'] = $page;	
		
		if($request->input('edit')!="") {
		
		
		  $id = $request->input('edit');
		  $data['id'] = $request->input('edit');
		  
		 $editdata = News::where('id',$id)
                     	  ->first();
						  
	    $data['news_title']  	    = $editdata['news_title'];
		$data['description']  		= base64_decode($editdata['description']);
		$data['main_img']  		    = $editdata['news_image'];
		$data['news_date']  		= date('d-m-Y',strtotime($editdata['news_date']));
		$data['news_location']  	= $editdata['news_location'];
		
	    $sub_image = NewsImage::where('news_id', $id)->get();
		
		//print_r($sub_image);exit;
		
		
		}
	
		$method = $request->method();
		if($method=='POST')
		{
		
		 $id = $request->input('id');
		 
		 $editdata = News::where('id',$id)
                     	  ->first();
		 $main_img  	 = $editdata['news_image'];
		 
		   $this->validate($request, [

            'news_date' => 'required|date_format:"d-m-Y"',
			'news_title' => 'required',
            'main_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
		
		
 
		 $news_title 	    = $request->news_title;
		 $description 		= base64_encode($request->description);
		 $news_date  		= date('Y-m-d',strtotime($request->news_date));
		 $news_location 	= $request->news_location;
					
	
		
			$image = $request->file('main_img');
			//print_r($image);exit;
		    if($image!="")
			{
	
			$orginal 	= public_path('/uploads/orginal/'.$main_img);
			$large 		= public_path('/uploads/large/'.$main_img);
			$medium 	= public_path('/uploads/medium/'.$main_img);
			$small 		= public_path('/uploads/small/'.$main_img);
			
			$files = array($orginal, $large, $medium, $small);
			\File::delete($files);
				
					
			$main_img= file_extesion($image);
	
	        $destinationPath = public_path('/uploads/orginal');
			$image->move($destinationPath, $main_img);
			
			//Resize image here
			$orginal_path = $destinationPath."/".$main_img;
			
			$thumbnailpath = public_path('/uploads/large/'.$main_img);
			$img = Image::make($orginal_path)->resize(800, 800, function($constraint) {
				$constraint->aspectRatio();
			})->save($thumbnailpath);
			
			$thumbnailpath = public_path('/uploads/medium/'.$main_img);
			$img = Image::make($orginal_path)->resize(250, 250, function($constraint) {
				$constraint->aspectRatio();
			})->save($thumbnailpath);
			
					
			$thumbnailpath = public_path('/uploads/small/'.$main_img);
			$img = Image::make($orginal_path)->fit(150, 150, function($constraint) {
	         $constraint->aspectRatio();
			})->save($thumbnailpath);
			
		}
				
		     $model2 = News::find($id);
			 $model2->news_title		= $news_title;
			 $model2->description 	= $description;
			 $model2->news_date 		= $news_date;
			 $model2->news_location 	= $news_location;
			 $model2->news_image 	= $main_img;

         $model2->save();
		 
		 
		    if($request->hasfile('subfile'))
			{
						
				foreach($request->file('subfile') as $sub_image)
				{
				
				$main_img = file_extesion($sub_image);
		
				$destinationPath = public_path('/uploads/orginal');
				$sub_image->move($destinationPath, $main_img);
				
				//Resize image here
				$orginal_path = $destinationPath."/".$main_img;
				
				$thumbnailpath = public_path('/uploads/large/'.$main_img);
				$img = Image::make($orginal_path)->resize(800, 800, function($constraint) {
					$constraint->aspectRatio();
				})->save($thumbnailpath);
				
				$thumbnailpath = public_path('/uploads/medium/'.$main_img);
				$img = Image::make($orginal_path)->resize(250, 250, function($constraint) {
					$constraint->aspectRatio();
				})->save($thumbnailpath);
				
						
				$thumbnailpath = public_path('/uploads/small/'.$main_img);
				$img = Image::make($orginal_path)->fit(150, 150, function($constraint) {
				 $constraint->aspectRatio();
				})->save($thumbnailpath);
				
				 
				 $modelsub = new NewsImage; 
				 
				 $modelsub->sub_image  	= $main_img;
				 $modelsub->news_id  	= $id;
				 $modelsub->save();

				
			  }
		   }
		   
		 session()->flash('success', 'News Updated Successfully');
		 return redirect('admin/list-news/?page='.$page);
		 
		
		}
		
		return view('admin.add-news',$data)->with('sub_image',$sub_image);
    }

      /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        
		$id = $request->del;
		$page	= ($request->input('page')) ? $request->input('page') : 1;

		if($id!="")
		{
		
		
		 $sub_image = NewsImage::where('news_id', $id)->get();
		 
		 foreach($sub_image as $key=>$val)
		 {

			$main_img = $val['sub_image'];
		
			if($main_img!="")
			{	
			
				$orginal 	= public_path('/uploads/orginal/'.$main_img);
				$large 		= public_path('/uploads/large/'.$main_img);
				$medium 	= public_path('/uploads/medium/'.$main_img);
				$small 		= public_path('/uploads/small/'.$main_img);
				
				$files = array($orginal, $large, $medium, $small);
				\File::delete($files);
				
				 NewsImage::find($val['id'])->delete();
			     
			}
		 
		 }
		 
		 
		 $res = News::where('id',$id)
                  ->first();
		$main_img = $res['news_image'];
		
		if($main_img!="")
		{		  
			
			$orginal 	= public_path('/uploads/orginal/'.$main_img);
			$large 		= public_path('/uploads/large/'.$main_img);
			$medium 	= public_path('/uploads/medium/'.$main_img);
			$small 		= public_path('/uploads/small/'.$main_img);
			
			$files = array($orginal, $large, $medium, $small);
			\File::delete($files);
		
		}
		
		    $model2 = News::find($id);
			$model2->delete();
			
			 session()->flash('success', 'News Deleted Successfully');
		     return redirect('admin/list-news/?page='.$page);
			
		}
    }
	
	 public function destroyimage(Request $request)
    {
        
		$id = $request->id;
		$page	= ($request->input('page')) ? $request->input('page') : 1;
		
	    $res = News::where('id',$id)
                  ->first();
		$main_img = $res['news_image'];
				  
		$orginal 	= public_path('/uploads/orginal/'.$main_img);
		$large 		= public_path('/uploads/large/'.$main_img);
		$medium 	= public_path('/uploads/medium/'.$main_img);
		$small 		= public_path('/uploads/small/'.$main_img);
		
		$files = array($orginal, $large, $medium, $small);
        \File::delete($files);

		if($id!="")
		{
		    $model2 = News::find($id);
			$model2->news_image = '';
			$model2->save();
			
			 session()->flash('success', 'Image Deleted Successfully');
		     return redirect('admin/edit-news/?edit='.$id.'&page='.$page);
		}
    }
	
	public function destroysubimage(Request $request)
    {
        
		$id = $request->id;
		$edit = $request->edit;
		
		$page	= ($request->input('page')) ? $request->input('page') : 1;
		
	    $res = NewsImage::where('id',$id)
                  ->first();
		$main_img = $res['sub_image'];
				  
		$orginal 	= public_path('/uploads/orginal/'.$main_img);
		$large 		= public_path('/uploads/large/'.$main_img);
		$medium 	= public_path('/uploads/medium/'.$main_img);
		$small 		= public_path('/uploads/small/'.$main_img);
		
		$files = array($orginal, $large, $medium, $small);
        \File::delete($files);

		if($id!="")
		{
		  
		    $model2 = NewsImage::find($id);
			$model2->delete();
			
			 session()->flash('success', 'Image Deleted Successfully');
		     return redirect('admin/edit-news/?edit='.$edit.'&page='.$page);
		}
    }
	
	
}
