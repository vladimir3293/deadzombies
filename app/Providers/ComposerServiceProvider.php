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
