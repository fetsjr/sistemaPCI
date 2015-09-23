<?php

namespace PCI\Providers;

use Illuminate\Support\ServiceProvider;
use PCI\Http\ViewComposers\NavbarViewComposer;
use PCI\Http\ViewComposers\UserShowViewComposer;

class ViewComposerServiceProvider extends ServiceProvider
{

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Using class based composers...
        view()->composer(
            'partials.navbar',
            NavbarViewComposer::class
        );

        view()->composer(
            'users.show',
            UserShowViewComposer::class
        );
    }
}
