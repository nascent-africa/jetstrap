<?php

namespace NascentAfrica\Jetstrap;

class Jetstrap
{
    /**
     * @var string
     */
    protected $presets = '';

    /**
     * Use Core Ui presets
     *
     * @return $this
     */
    public function useCoreUi3(): Jetstrap
    {
        $this->presets = Presets::CORE_UI_3;

        return $this;
    }

    /**
     * Use Core Ui presets
     *
     * @return $this
     */
    public function useAdminLte3(): Jetstrap
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