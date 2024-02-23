<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
Use DB;

class Api extends Controller
{
    public function datalist($id="",Request $request)
	{
	  $table = DB::table('api');
	  
	  if($request->input('id')!="") {
		$id = $request->input('id');
	  	$table->where('id',$id);
	  }
	  
	    if($id!="") {
	  	$table->where('id',$id);
	  }
	  
	  $result 	= $table->get();
	  return response()->json(['data' => $result  ], 200);
	}
}
