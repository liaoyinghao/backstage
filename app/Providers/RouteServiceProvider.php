<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapExamRoutes();
        $this->mapWxRoutes();
        $this->mapShopRoutes();
        $this->mapExecRoutes();

        $this->mapH5Routes();
        $this->mapManageRoutes();
        $this->mapUserRoutes();

        $this->mapPosRoutes();
        $this->mapQRoutes();
        $this->mapYRoutes();
    }

    //h5页面
    public function mapH5Routes(){
        Route::prefix('h5')
             ->middleware('h5')
             ->namespace($this->namespace.'\H5')
             ->name('h5_')
             ->group(base_path('routes/h5.php'));
    }

    //运营界面
    public function mapManageRoutes(){
        Route::prefix('m')
             ->middleware('manage')
             ->namespace($this->namespace.'\Manage')
             ->name('manage_')
             ->group(base_path('routes/manage.php'));
    }

    //用户界面
    public function mapUserRoutes(){
        Route::prefix('i')
             ->middleware('user')
             ->namespace($this->namespace.'\User')
             ->name('user_')
             ->group(base_path('routes/user.php'));
    }

    //店铺
    public function mapShopRoutes(){
        Route::prefix('shop')
             ->middleware('shop')
             ->namespace($this->namespace.'\Shop')
             ->name('shop_')
             ->group(base_path('routes/shop.php'));
    }

    //剑客
    public function mapExecRoutes(){
        Route::prefix('exec')
             ->middleware('exec')
             ->namespace($this->namespace.'\Exec')
             ->name('exec_')
             ->group(base_path('routes/exec.php'));
    }

    //pos机
    public function mapPosRoutes(){
        Route::prefix('pos')
             ->middleware('pos')
             ->namespace($this->namespace.'\Pos')
             ->name('pos_')
             ->group(base_path('routes/pos.php'));
    }

    //渠道商
    public function mapQRoutes(){
        Route::prefix('q')
             ->middleware('q')
             ->namespace($this->namespace.'\Q')
             ->name('q_')
             ->group(base_path('routes/q.php'));
    }


    //运营商
    public function mapYRoutes(){
        Route::prefix('y')
             ->middleware('y')
             ->namespace($this->namespace.'\Y')
             ->name('y_')
             ->group(base_path('routes/y.php'));
    }

    //test route
    protected function mapExamRoutes()
    {
        Route::prefix('exam')
             ->middleware('web')
             ->namespace($this->namespace.'\Exam')
             ->name('exam_')
             ->group(base_path('routes/exam.php'));
    }

    protected function mapWxRoutes()
    {
        Route::prefix('wx')
             ->middleware('wx')
             ->namespace($this->namespace.'\Wx')
             ->name('wx_')
             ->group(base_path('routes/wx.php'));
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
