<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Menu;
Use DB;
use Schema;
use Config;

class MenuController extends Controller
{
    function index(Request $request)
    {
		$data['adddiv'] 		= "none";
        $data['srdiv'] 			= "none";
		$data['set_home']		= "no";
		$data['menu_id']		= "";
		$data['page']			= ($request->input('page')) ? $request->input('page') : 1;
		if($request->input('add')==1) { $data['adddiv']= "block"; } else {  $data['adddiv']= "none"; }
		
		if($request->input('edit')!="") {
		
			$data['adddiv'] 		= "block";
            $data['srdiv'] 			= "none";
		
		  	$id = $request->input('edit');
		  	$data['id'] = $request->input('edit');
		  
		 	$editdata = Menu::where('id',$id)
                     	  ->first();
						  
			$data['name']  			= $editdata['name'];
			$data['url']  			= $editdata['url'];
			$data['icon']  			= $editdata['icon'];
			$data['menu_order']  	= $editdata['menu_order'];
			$data['menu_table']  	= $editdata['menu_table'];
			$data['active_file']  	= $editdata['active_file'];
			$data['color']  		= $editdata['color'];
			$data['set_home']  		= $editdata['show_home'];
			$data['menu_id']  		= $editdata['menu_id'];
			$data['menu_data']      = Menu::get_menu_list();
		
		}
		else
		{
		
			$data['menu_data'] = Menu::get_menu_list();
			$max_ordr = Menu::max('menu_order');
			$data['menu_order'] = $max_ordr+1;
		
		}
		
	    $query = Menu::where('menu_type','menu');
		
			 if( !empty($request->input('sr_name')) )
			  {
				 $sr_name = $request->input('sr_name');
				 $data['sr_name'] 	= $sr_name;
				 $query->where('name',$sr_name);
				 $data['adddiv'] = "none";
		         $data['srdiv'] = "block";
			  }
			  
			  if( !empty($request->input('sr_tbl')))
			  {
				 $sr_tbl = trim($request->input('sr_tbl'));
				 $data['sr_tbl'] 	= $sr_tbl;
				 $query->where('menu_table',$sr_tbl);
				 $data['adddiv'] = "none";
		         $data['srdiv'] = "block";
			  }

	    $query->orderBy('id', 'desc');
		$results = $query->paginate(Config::get('constants.PG_LIMIT_AD'));
		
		return view('admin.manage-menu')->with($data)->with('results',$results);
    }
	
    function add(Request $request)
    {
	 	$data['adddiv'] 		= "block";
        $data['srdiv'] 			= "none";

		$data['page']			= ($request->input('page')) ? $request->input('page') : 1;
		
		 $validator = Validator::make($request->all(),[
			'name' => 'required',
			'menu_order' => 'required',
		  ],
		  [
			'name.required' => 'The menu name field is required.',
			'menu_order.required' => 'The menu order field is required.',
		  ]);
		  
		  if ($validator->fails()) {
		  
			   return redirect('admin/menu-management/?add=1')->withErrors($validator)->withInput();
		  }
		 $model = new Menu;
		 
		 $menu_id 		= $request->menu_id;
		 $menu_order 	= $request->menu_order;
		 $menu_type 	= $request->menu_type;
		 
		 $menu_table 	= $request->menu_table;
		 
		 if(!Schema::hasTable($menu_table))
		 {
		    $menu_table = "";
		 }
		 
		  if($menu_id !="") { $menu_type = "sub-menu"; }
		  else { $menu_type = "menu"; }
		 
		 
		 if($menu_id!="") { 
						
			$ord_exist = $model->where('menu_order',$menu_order)
					                ->where('menu_type',$menu_type)
									->where('menu_id',$menu_id)
                                    ->first();
									
			} else {
					
					   $ord_exist = $model->where('menu_order',$menu_order)
					                ->where('menu_type',$menu_type)
                                    ->first();
		 }
		
		
		if($ord_exist)
		 {	 
					  $exist_id = $ord_exist->id;
						
						if($menu_id!="") { 
						
						$model->where('menu_order',$menu_order)
					                ->where('menu_type',$menu_type)
									->where('menu_id',$menu_id);
      
									
		} else {
					
					  $model->where('menu_order',$menu_order)
					         ->where('menu_type',$menu_type);
                               
			}
					
						$max_ordr = $model->max('menu_order');
						$menuord  = $max_ordr+1;
						
						$model->where('id', $exist_id)
					          ->update(['menu_order' => $menuord]);
	
		}
				
		 
         $model->name			= $request->name;
		 $model->url 			= $request->url;
		 $model->icon 			= $request->icon;
		 $model->menu_order 	= $request->menu_order;
		 $model->menu_table 	= $menu_table;
		 $model->active_file 	= $request->active_file;
		 $model->color 			= $request->color;
		 $model->show_home 		= $request->set_home;
		 $model->menu_type 		= $menu_type;
		 $model->menu_id 		= $menu_id;
		 
         $model->save();
		 session()->flash('success', 'Menu Created Successfully');
		 return redirect('admin/menu-management/?add=1');
	}
	
	function edit(Request $request)
    {
		
		$id = $request->id;
		$page	= ($request->input('page')) ? $request->input('page') : 1;
		
		 $validator = Validator::make($request->all(),[
			'name' => 'required',
			'menu_order' => 'required',
		  ],
		  [
			'name.required' => 'The menu name field is required.',
			'menu_order.required' => 'The menu order field is required.',
		  ]);
		  
		  if ($validator->fails()) {
		  
			   return redirect('admin/menu-management/?edit='.$id)->withErrors($validator)->withInput();
		  }
		  
	
		
		 $model = new Menu;
		 
		 $menu_id 		= $request->menu_id;
		 $menu_order 	= $request->menu_order;
		 $menu_type 	= $request->menu_type;
		 
		 $menu_table 	= $request->menu_table;
		 
		 if(!Schema::hasTable($menu_table))
		 {
		    $menu_table = "";
		 }
		 
		  if($menu_id !="") { $menu_type = "sub-menu"; }
		 else { $menu_type = "menu"; }
		 
		 
		 if($menu_id!="") { 
						
			$ord_exist = $model->where('menu_order',$menu_order)
					                ->where('menu_type',$menu_type)
									->where('menu_id',$menu_id)
									->where('id','!=',$id)
                                    ->first();
									
			} else {
					
					   $ord_exist = $model->where('menu_order',$menu_order)
					                ->where('menu_type',$menu_type)
									->where('id','!=',$id)
                                    ->first();
		}
		
		
		if($ord_exist)
		 {	 
					  $exist_id = $ord_exist->id;
						
						if($menu_id!="") { 
						
						$model->where('menu_order',$menu_order)
					                ->where('menu_type',$menu_type)
									->where('menu_id',$menu_id);
      
									
		} else {
					
					  $model->where('menu_order',$menu_order)
					         ->where('menu_type',$menu_type);
                               
			}
					
						$max_ordr = $model->max('menu_order');
						$menuord  = $max_ordr+1;
						
						$model->where('id', $exist_id)
					          ->update(['menu_order' => $menuord]);
	
		}
				
		 $model2 = Menu::find($id);
         $model2->name			= $request->name;
		 $model2->url 			= $request->url;
		 $model2->icon 			= $request->icon;
		 $model2->menu_order 	= $request->menu_order;
		 $model2->menu_table 	= $menu_table;
		 $model2->active_file 	= $request->active_file;
		 $model2->color 			= $request->color;
		 $model2->show_home 		= $request->set_home;
		 $model2->menu_type 		= $menu_type;
		 $model2->menu_id 		= $menu_id;
		 
         $model2->save();
		 session()->flash('success', 'Menu Updated Successfully');
		 return redirect('admin/menu-management/?page='.$page);
	}
	
	function delete(Request $request)
	{
	
	    $id = $request->del;
		$page	= ($request->input('page')) ? $request->input('page') : 1;
		
		$model = new Menu;
		
		if($id!="")
		{
		
		 //  	DB::enableQueryLog();
		   $ord_exist = $model->where('menu_type','sub-menu')
							  ->where('menu_id',$id)
                              ->first();
		  
		   if($ord_exist)
		   {
		
			$model->where('menu_id', $id)
				 ->update(['menu_type' => 'menu', 'menu_id' => 0 ]); 
			  
			 //  $query = DB::getQueryLog();
             //  dd($query);
	
		   }
		   
		    $model2 = Menu::find($id);
			$model2->delete();
			
			 session()->flash('success', 'Menu Deleted Successfully');
		     return redirect('admin/menu-management/?page='.$page);
			
		}
		
		
	}
	
	function status(Request $request)
	{
	  
	    $id = $request->id;
		$st = $request->st;
		 
		$page	= ($request->input('page')) ? $request->input('page') : 1;
		
		$model = new Menu;
		
		$model->where('id', $id)
			  ->update(['status' => $st]); 

		session()->flash('success', 'Menu Status Changed Successfully');
		return redirect('admin/menu-management/?page='.$page);
	}
	
}
