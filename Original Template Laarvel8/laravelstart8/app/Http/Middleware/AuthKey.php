<?php

namespace App\Http\Middleware;

use Closure;

class AuthKey
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
        $token = $request->header('APPKEY');//not use underscore header
		if($token != '2074@seb#209Y')
		{
		  return response()->json(['message' => 'App key not found.' ], 401);
		}
		else
		{
		return $next($request);
		}
    }
}
