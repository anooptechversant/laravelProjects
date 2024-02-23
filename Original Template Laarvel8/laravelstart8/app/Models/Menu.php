<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;
use Schema;
Use DB;

class Menu extends Model
{
      protected $table = 'left_menu';
	  protected $primaryKey = 'id';
	  public $timestamps = false;
	  
	  
	     public static function menu_count_table($fldtable=NULL) 
		{
			$result = Schema::getColumnListing($fldtable);
			
			if(@in_array('status', $result))
			{
			   $query 	= DB::table($fldtable)->where('status','active');
			}
			else
			{
			   $query	=	DB::table($fldtable);
			}
			 
			return $query->count();
		}
		
		public static function get_menu_dashboard() 
		{
			
			$query = Menu::orderBy('id','asc');
			
			if(Session::get('ma_admintype')=='admin')
			{
				$query->where('show_home','yes');
			}
			else
			{
				$query->where('show_home','yes');
				$query->where('menu_table','!=', 'admin');
			}
			
			 return $query->get();

		}
	
		  
		 public static function get_menu($menu_type)
		{
			
			$query = Menu::orderBy('menu_order','asc');
			
			$query->where('menu_type',$menu_type);
			
			if(Session::get('ma_admintype')!='admin')
			{
				$query->where('menu_table','!=', 'admin');
			}

			//print_r( $query->get());exit;
			return $query->get();
		
		}
	
		 public static function get_sub_menu($menu_id)
		{
	
			$query = Menu::where('menu_type','sub-menu')
					->where('menu_id', $menu_id)
					->orderBy('menu_order','asc');
		
			return $query->get();
		}
		
		public static function get_menu_list()
		{
			$query = Menu::where('menu_type','menu')
			               ->select('id','name') 
						   ->orderBy('name','asc');
			return $query->get();
		}

		
}
