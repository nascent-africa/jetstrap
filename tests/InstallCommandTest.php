<?php

namespace NascentAfrica\Jetstrap\Tests;

use NascentAfrica\Jetstrap\JetstrapFacade;

class InstallCommandTest extends TestCase
{
    /** @test */
    public function livewire_swapped()
    {
        // Run the make command
        $this->artisan('jetstrap:swap livewire')
            ->expectsOutput('Bootstrap scaffolding swapped for livewire successfully.')
            ->expectsOutput('Please execute the "npm install && npm run dev" command to build your assets.')
            ->assertExitCode(0);

        $this->basicTests();
        $this->basicLivewireTests();
    }

    /** @test */
    public function inertia_swapped()
    {
        // Run the make command
        $this->artisan('jetstrap:swap inertia')
            ->expectsOutput('Bootstrap scaffolding swapped for inertia successfully.')
            ->expectsOutput('Please execute the "npm install && npm run dev" command to build your assets.')
            ->assertExitCode(0);

        $this->basicTests();
        $this->basicInertiaTests();
    }

    /** @test */
    public function livewire_swapped_with_teams()
    {
        // Run the make command
        $this->artisan('jetstrap:swap livewire --teams')
            ->expectsOutput('Bootstrap scaffolding swapped for livewire successfully.')
            ->expectsOutput('Please execute the "npm install && npm run dev" command to build your assets.')
            ->assertExitCode(0);

        $this->basicTests();
        $this->basicLivewireTests();
        $this->livewireTeamTests();
    }

    /** @test */
    public function inertia_swapped_teams()
    {
        // Run the make command
        $this->artisan('jetstrap:swap inertia --teams')
            ->expectsOutput('Bootstrap scaffolding swapped for inertia successfully.')
            ->expectsOutput('Please execute the "npm install && npm run dev" command to build your assets.')
            ->assertExitCode(0);

        $this->basicTests();
        $this->basicInertiaTests();
        $this->inertiaTeamTests();
    }

    /** @test */
    public function livewire_core_ui_swap()
    {
        JetstrapFacade::useCoreUi3();

        // Run the make command
        $this->artisan('jetstrap:swap livewire')
            ->assertExitCode(0);

        $this->basicTests();
        $this->basicLivewireTests();
    }

    /** @test */
    public function inertia_core_ui_swap()
    {
        JetstrapFacade::useCoreUi3();

        // Run the make command
        $this->artisan('jetstrap:swap inertia')
            ->assertExitCode(0);

        $this->basicTests();
        $this->basicInertiaTests();
    }

    /** @test */
    public function livewire_admin_lte_swap()
    {
        JetstrapFacade::useAdminLte3();

        // Run the make command
        $this->artisan('jetstrap:swap livewire')
            ->assertExitCode(0);

        $this->basicTests();
        $this->basicLivewireTests();
    }

    /** @test */
    public function inertia_admin_lte_swap()
    {
        JetstrapFacade::useAdminLte3();

        // Run the make command
        $this->artisan('jetstrap:swap inertia')
            ->assertExitCode(0);

        $this->basicTests();
        $this->basicInertiaTests();
    }
}
