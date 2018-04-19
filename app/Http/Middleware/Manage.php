<?php

namespace App\Http\Middleware;
use Closure;
use App\Models\Calendar;
use App\Models\Accountnum;

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

       $GLOBALS['m']['user']=$request->cookie('backstage_user');
       $GLOBALS['m']['quanxian']=$request->cookie('backstage_user_quanxian');

        $info = Accountnum::userinfo($GLOBALS['m']['user']);
        $infos = Calendar::where("uid",$info['id'])->where("status",1)->get();
        $count = 0;
        foreach ($infos as $key => $val) {
            $times = date("Y-m-d",time());
            if($val['betime'] <= $times){
              $count++;
            }
        }
        view()->share('calendarcount' , $count);
        return $next($request);
    }
}
