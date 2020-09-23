<?php

namespace NascentAfrica\Jetstrap;

use Illuminate\Support\Facades\Facade;

/**
 * @method static Jetstrap bootstrap4()
 * @method static Jetstrap bootstrap5()
 * @method static bool isBootstrap4()
 * @method static bool isBootstrap5()
 *
 * @see Jetstrap
 */
class JetstrapFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'jetstrap';
    }
}