<?php

namespace NascentAfrica\Jetstrap;

use Illuminate\Support\Facades\Facade;

/**
 * @method static Jetstrap bootstrap4()
 * @method static Jetstrap bootstrap5()
 * @method static bool isBootstrap4()
 * @method static bool isBootstrap5()
 * @method static Jetstrap useCoreUi3()
 * @method static Jetstrap useAdminLte3()
 * @method static false|string getPreset()
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