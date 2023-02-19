<?php

namespace App\Providers;

use App\Facades\Python;
use Illuminate\Support\ServiceProvider;

class PythonServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('PythonAccessor', function () {
            return $this->app->make(Python\PythonAccessor::class);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
