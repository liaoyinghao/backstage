<?php

namespace App\Http\Middleware;
use Closure;

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

       if(!$request->cookie('backstage_user',0) && !in_array( array_pad( explode('/',request()->path()),2,0)[1] , ['login' , 'loginpost']) ){
           return redirect()->route('manage_login');
       }

        return $next($request);
    }
}
