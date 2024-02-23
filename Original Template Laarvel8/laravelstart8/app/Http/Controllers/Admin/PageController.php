<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Page;
use Image;
use Config;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['srdiv'] 			= "none";
		
	  //  $data['ut'] 			= "";
		//$data['user_type'] 		= "";

		$data['page']			= ($request->input('page')) ? $request->input('page') : 1;
		

	       $query = Page::orderBy('id', 'desc');
		
			 if( !empty($request->input('un')) )
			  {
				 $un = $request->input('un');
				 $data['un'] 	= $un;
				 $query->where('title','like','%'.$un.'%');
				 $data['srdiv'] = "block";
			  }
			  
			  
		$results = $query->paginate(Config::get('constants.PG_LIMIT_AD'));
		
		return view('admin.list-page')->with($data)->with('results',$results);
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

            'pagep' => 'required',
			'title' => 'required',
            'main_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
		
			
				 
		 $title 		    = $request->title;
		 $description 		= base64_encode($request->description);
		 $pagep 			= $request->pagep;
		 $created_date 	    = date('Y-m-d');
	     
		 $exist = Page::where('page',$pagep)
                  ->first();
					
		if($exist)
		{
		 
           session()->flash('errormsg', 'Page already exists.');
		   return redirect()->back()->withInput();
		  // return redirect('admin/list-admin/?add=1');
		 
		}
		else
		{
		

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
		
			
			 $model = new Page;
			 $model->title			= $title;
			 $model->description 	= $description;
			 $model->page 			= $pagep;
			 $model->image 			= $main_img;
			 $model->created_date 	= $created_date;
 
			 $model->save();
			 session()->flash('success', 'Page Created Successfully');
			 return redirect('admin/add-page');

					
		}
		
		}
		
		return view('admin.add-page');

		 
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
		  
		 $editdata = Page::where('id',$id)
                     	  ->first();
						  
	    $data['title']  			= $editdata['title'];
		$data['description']  		= base64_decode($editdata['description']);
		$data['main_img']  		    = $editdata['image'];
		$data['pagep']  			= $editdata['page'];
		
		
		
		}
	
		$method = $request->method();
		if($method=='POST')
		{
		
		 $id = $request->input('id');
		 
		 $editdata = Page::where('id',$id)
                     	  ->first();
		 $main_img  	 = $editdata['image'];
		 
		$this->validate($request, [

            'pagep' => 'required',
			'title' => 'required',
            'main_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
		
 
		 $title 		    = $request->title;
		 $description 		= base64_encode($request->description);
		 $pagep 			= $request->pagep;

		 $exist = Page::where('page',$pagep)
		          ->where('id','!=',$id)
                  ->first();
					
		if($exist)
		{
		 
           session()->flash('errormsg', 'Page already exists.');
		   return redirect()->back()->withInput();
		 
		}
		else
		{
		
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
				
		 $model2 = Page::find($id);
         $model2->title			= $title;
		 $model2->description 	= $description;
		 $model2->page 			= $pagep;
		 $model2->image 	    = $main_img;

         $model2->save();
		 session()->flash('success', 'Page Updated Successfully');
		 return redirect('admin/list-page/?page='.$page);
		 
		 }
		 
		}
		
		return view('admin.add-page',$data);
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
		 
		 $res = Page::where('id',$id)
                  ->first();
		$main_img = $res['image'];
		
		if($main_img!="")
		{		  
			
			$orginal 	= public_path('/uploads/orginal/'.$main_img);
			$large 		= public_path('/uploads/large/'.$main_img);
			$medium 	= public_path('/uploads/medium/'.$main_img);
			$small 		= public_path('/uploads/small/'.$main_img);
			
			$files = array($orginal, $large, $medium, $small);
			\File::delete($files);
		
		}
		
		    $model2 = Page::find($id);
			$model2->delete();
			
			 session()->flash('success', 'Page Deleted Successfully');
		     return redirect('admin/list-page/?page='.$page);
			
		}
    }
	
	 public function destroyimage(Request $request)
    {
        
		$id = $request->id;
		$page	= ($request->input('page')) ? $request->input('page') : 1;
		
	    $res = Page::where('id',$id)
                  ->first();
		$main_img = $res['image'];
				  
		$orginal 	= public_path('/uploads/orginal/'.$main_img);
		$large 		= public_path('/uploads/large/'.$main_img);
		$medium 	= public_path('/uploads/medium/'.$main_img);
		$small 		= public_path('/uploads/small/'.$main_img);
		
		$files = array($orginal, $large, $medium, $small);
        \File::delete($files);

		if($id!="")
		{
		    $model2 = Page::find($id);
			$model2->image = '';
			$model2->save();
			
			 session()->flash('success', 'Image Deleted Successfully');
		     return redirect('admin/edit-page/?edit='.$id.'&page='.$page);
		}
    }
	
	
}
