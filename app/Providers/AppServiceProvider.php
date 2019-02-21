<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */


    public function boot()
    {
//        if(App::getLocale() == 'en'){
//            \Carbon\Carbon::setLocale('en');
//        }else{
//            \Carbon\Carbon::setLocale('zh');
//        }
        \Carbon\Carbon::setLocale('zh');
//        view()->share('sitename','text6');
//        view()->composer('*',function($view){
//            $view->with('user',array('name'=>'text','avatar'=>'/pah/to/test.jpg'));
//        });

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
