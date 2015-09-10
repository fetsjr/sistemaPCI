<?php

namespace PCI\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Cambia la direccion del directorio publico
         * del standard a lo que sea...
         * en este caso se cambio a .../sistemaPCI/Public
         */
        $this->app->bind('path.public', function () {
            return base_path().'/../public';
        });
    }
}
