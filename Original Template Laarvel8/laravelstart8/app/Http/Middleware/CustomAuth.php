<?php
namespace App\Http\Middleware;

use Closure;
use Session;

class CustomAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       // echo "test";
		$path = $request->path();
		//echo Session::get('ma_adminuser');
		//echo $path;exit;
		
	   if(Session::get('ma_adminuser') && ($path=='admin/login' || $path=='admin'))
		{
		  return redirect('admin/dashboard');
		}
		else if(!Session::get('ma_adminuser') && $path!='admin/login' && $path!='admin')
		{
		  return redirect('admin/login');
		}
		
		return $next($request);
    }
}
