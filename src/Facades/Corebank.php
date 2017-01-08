<?php

namespace Teepluss\Corebank\Facades;

use Illuminate\Support\Facades\Facade;

class Corebank extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'corebank.client'; }

}
