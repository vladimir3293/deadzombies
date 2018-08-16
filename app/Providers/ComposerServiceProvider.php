<?php

namespace Deadzombies\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('menu', 'Deadzombies\Http\ViewComposers\MenuComposer');
        View::composer('topBlock', 'Deadzombies\Http\ViewComposers\TopBlockComposer');

        //View::composer('admin.menu', 'Deadzombies\Http\ViewComposers\AdminMenuComposer');
        //View::composer('sidebar', 'Deadzombies\Http\ViewComposers\SidebarComposer');
        //View::composer('gameCard', 'Deadzombies\Http\ViewComposers\GameCardComposer');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
