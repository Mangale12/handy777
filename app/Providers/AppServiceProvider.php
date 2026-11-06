<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use DB;
use App\Repositories\CoinsAddressRepositoryInterface;
use App\Repositories\CoinsAddressRepository;
use App\Repositories\NetWorkRepositoryInterface;
use App\Repositories\NetWorkRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NetWorkRepositoryInterface::class, NetWorkRepository::class);
        $this->app->bind(CoinsAddressRepositoryInterface::class, CoinsAddressRepository::class);
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        // view()->share('color',$color);
        View::composer('layouts.newLayout', function ($view) {
        $color = DB::table('sidebar')->where('id',1)->first('color');
            $view->with('color',$color);
        });
        
        $lifetime = env('LIFETIME', 5);
        config(['session.lifetime' => $lifetime]);
    }
}
