<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Admin;

class Manage
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

//        if(!$request->cookie('manage_uid',0) && !in_array( array_pad( explode('/',request()->path()),2,0)[1] , ['login' , 'process']) ){
//            return redirect()->route('manage_login');
//        }

        return $next($request);
    }
}
