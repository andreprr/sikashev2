<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $verticalMenuJson = file_get_contents(base_path('resources/menu/default_menu.json'));
        $verticalMenuData = json_decode($verticalMenuJson);

        // Share all menuData to all the views
        \View::share('menuData', [$verticalMenuData]);
        
        Paginator::useBootstrapFive();
    }
}
