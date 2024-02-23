<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\AdminLogin;
use Config;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['adddiv'] 		= "none";
        $data['srdiv'] 			= "none";
	    $data['ut'] 			= "";
		$data['user_type'] 		= "";

		$data['page']			= ($request->input('page')) ? $request->input('page') : 1;
		if($request->input('add')==1) { $data['adddiv']= "block"; } else {  $data['adddiv']= "none"; }
		
		if($request->input('edit')!="") {
		
			$data['adddiv'] 		= "block";
            $data['srdiv'] 			= "none";
		
		  $id = $request->input('edit');
		  $data['id'] = $request->input('edit');
		  
		 $editdata = AdminLogin::where('id',$id)
                     	  ->first();
						  
	    $data['username']  			= $editdata['username'];
		$data['password']  			= decrypt_password($editdata['password']);
		$data['user_type']  		= $editdata['user_type'];
		$data['status']  			= $editdata['status'];
		
		
		}
	
		
	       $query = AdminLogin::where('id','!=',1);
		
			 if( !empty($request->input('un')) )
			  {
				 $un = $request->input('un');
				 $data['un'] 	= $un;
				 $query->where('username',$un);
				 $data['adddiv'] = "none";
		         $data['srdiv']  = "block";
			  }
			  
			  if( !empty($request->input('ut')))
			  {
				 $ut = trim($request->input('ut'));
				 $data['ut'] 	= $ut;
				 $query->where('user_type',$ut);
				 $data['adddiv'] = "none";
		         $data['srdiv']  = "block";
			  }

	    $query->orderBy('id', 'desc');
		$results = $query->paginate(Config::get('constants.PG_LIMIT_AD'));
		
		return view('admin.list-admin')->with($data)->with('results',$results);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data['adddiv'] 		= "block";
        $data['srdiv'] 			= "none";

		$data['page']			= ($request->input('page')) ? $request->input('page') : 1;
		
		 $validator = Validator::make($request->all(),[
			'username' => 'required',
			'password' => 'required',
			'user_type' => 'required',
		  ],
		  [
			'username.required' => 'The Username field is required.',
			'password.required' => 'The Password field is required.',
			'user_type.required' => 'The User Type field is required.',
		  ]);
		  
		  if ($validator->fails()) {
		  
			    return redirect()->back()->withInput();
		  }
		
		
		 
		 $username 		= $request->username;
		 $password 		= $request->password;
		 $user_type 	= $request->user_type;
		 $status 	    = 'active';
	     
		 $exist = AdminLogin::where('username',$username)
                  ->first();
					
		if($exist)
		{
		 
           session()->flash('errormsg', 'Username already exists.');
		   return redirect()->back()->withInput();
		  // return redirect('admin/list-admin/?add=1');
		 
		}
		else
		{
			 $model = new AdminLogin;
			 $model->username	= $username;
			 $model->password 	= encrypt_password($password);
			 $model->user_type 	= $user_type;
			 $model->status 	= $status;
 
			 $model->save();
			 session()->flash('success', 'Admin User Created Successfully');
			 return redirect('admin/list-admin/?add=1');

					
		}

		 
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        
		$id = $request->id;

		$page	= ($request->input('page')) ? $request->input('page') : 1;
		
		 $validator = Validator::make($request->all(),[
			'username' => 'required',
			'password' => 'required',
			'user_type' => 'required',
		  ],
		  [
			'username.required' => 'The Username field is required.',
			'password.required' => 'The Password field is required.',
			'user_type.required' => 'The User Type field is required.',
		  ]);
		  
		  
		  if ($validator->fails()) {
		  
			    return redirect()->back()->withInput();
		  }
	
		
		 
		 $username 		= $request->username;
		 $password 		= $request->password;
		 $user_type 	= $request->user_type;
		 $status 	    = 'active';
		 
		 
		 $exist = AdminLogin::where('username',$username)
		          ->where('id','!=',$id)
                  ->first();
					
		if($exist)
		{
		 
           session()->flash('errormsg', 'Username already exists.');
		   return redirect()->back()->withInput();
		  // return redirect('admin/list-admin/?add=1');
		 
		}
		else
		{
				
		 $model2 = AdminLogin::find($id);
         $model2->username	= $username;
		 $model2->password 	= encrypt_password($password);
		 $model2->user_type 	= $user_type;

		 
         $model2->save();
		 session()->flash('success', 'Admin User Updated Successfully');
		 return redirect('admin/list-admin/?page='.$page);
		 
		 }
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
		
		    $model2 = AdminLogin::find($id);
			$model2->delete();
			
			 session()->flash('success', 'Admin User Deleted Successfully');
		     return redirect('admin/list-admin/?page='.$page);
			
		}
    }
	
	public function status(Request $request)
	{
	  
	    $id = $request->id;
		$st = $request->st;
		 
		$page	= ($request->input('page')) ? $request->input('page') : 1;
		
		$model = new AdminLogin;
		
		$model->where('id', $id)
			  ->update(['status' => $st]); 

		session()->flash('success', 'Admin User Status Changed Successfully');
		return redirect('admin/list-admin//?page='.$page);
	}
}
