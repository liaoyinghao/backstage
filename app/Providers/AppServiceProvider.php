<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $view_path=array_pad(explode('/' , request()->path()) , 5 , 'null');//查询并补足长度
        view()->share('view_path' , $view_path);
        if($view_path[0]=='m'){
            view()->share('left_menu' , config('managemenu'));
        }

        if($view_path[0]=='shop'){
            view()->share('left_menu' , config('shopmenu'));
        }

        if($view_path[0]=='exec'){
            view()->share('left_menu' , config('execmenu'));
        }

        if($view_path[0]=='q'){
            view()->share('left_menu' , config('qudaomenu'));
        }

        if($view_path[0]=='y'){
            view()->share('left_menu' , config('ymenu'));
        }

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
