<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\View\Composers\HeaderComposer;
use App\Http\View\Composers\SidebarComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

   

    public function boot()
    { 

        View::composer('common.header', HeaderComposer::class);
        View::composer('common.sidebar', SidebarComposer::class);
    }
}
