<?php

namespace App\Providers;

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
//        view()->share('sitename','text6');
//        view()->composer('*',function($view){
//            $view->with('user',array('name'=>'text','avatar'=>'/pah/to/test.jpg'));
//        });

        view()->composer(
            '*', 'App\Http\ViewComposers\commonComposer'
        );
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
