<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Helper;

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

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            Schema::defaultStringLength(191);

            // $lala = Helper::getAllCategory();
            // foreach($lala as $category){
            //     $children = $category->child_cat;
            //     if($children->isNotEmpty()){
            //         dd($category, $children);
            //     }
            // }
            // $view->with(['lala' => $lala ]);
        });
    }
}
