<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class PythonFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'PythonAccessor';
    }
}
