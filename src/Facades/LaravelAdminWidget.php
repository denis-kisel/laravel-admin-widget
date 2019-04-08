<?php

namespace DenisKisel\LaravelAdminWidget\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelAdminWidget extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laraveladminwidget';
    }
}
