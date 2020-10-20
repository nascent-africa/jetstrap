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
     * @var string
     */
    protected $presets = '';

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

    /**
     * Use Core Ui presets
     *
     * @return $this
     */
    public function useCoreUi3()
    {
        $this->presets = Presets::CORE_UI_3;

        return $this;
    }

    /**
     * Use Core Ui presets
     *
     * @return $this
     */
    public function useAdminLte3()
    {
        $this->presets = Presets::ADMIN_LTE_3;

        return $this;
    }

    /**
     * Get preset name
     *
     * @return false|string
     */
    public function getPreset()
    {
        return $this->presets === '' ? false : $this->presets;
    }
}