<?php

namespace NascentAfrica\Jetstrap;

class Jetstrap
{
    /**
     * Bootstrap version
     *
     * @var int
     */
    protected $bootstrapVersion = 5;

    /**
     * Use bootstrap 4 as the default for scaffolding.
     *
     * @return $this
     */
    public function bootstrap4()
    {
        $this->bootstrapVersion = 4;
        return $this;
    }

    /**
     * Use bootstrap 5 as the default for scaffolding.
     *
     * @return $this
     */
    public function bootstrap5()
    {
        $this->bootstrapVersion = 5;
        return $this;
    }

    /**
     * Check that the current bootstrap version is 4
     *
     * @return bool
     */
    public function isBootstrap4(): bool
    {
        return $this->bootstrapVersion === 4;
    }

    /**
     * Check that the current bootstrap version is 5
     *
     * @return bool
     */
    public function isBootstrap5(): bool
    {
        return $this->bootstrapVersion === 5;
    }
}