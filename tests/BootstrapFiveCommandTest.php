<?php

namespace NascentAfrica\Jetstrap\Tests;

use NascentAfrica\Jetstrap\JetstrapFacade;

class BootstrapFiveCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Set default to Bootstrap 5
        JetstrapFacade::bootstrap5();
    }

    /** @test */
    public function livewire_swapped()
    {
        $this->cleanLivewireFiles($this->filesystem);

        // Run the make command
        $this->artisan('jetstrap:swap:bootstrap-5 livewire')
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
        $this->artisan('jetstrap:swap:bootstrap-5 inertia')
            ->expectsOutput('Bootstrap scaffolding swapped for inertia successfully.')
            ->expectsOutput('Please execute the "npm install && npm run dev" command to build your assets.')
            ->assertExitCode(0);

        $this->basicTests();
        $this->basicInertiaTests();
    }

    /** @test */
    public function livewire_swapped_with_teams()
    {
        $this->cleanLivewireFiles($this->filesystem);

        // Run the make command
        $this->artisan('jetstrap:swap:bootstrap-5 livewire --teams')
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
        $this->artisan('jetstrap:swap:bootstrap-5 inertia --teams')
            ->expectsOutput('Bootstrap scaffolding swapped for inertia successfully.')
            ->expectsOutput('Please execute the "npm install && npm run dev" command to build your assets.')
            ->assertExitCode(0);

        $this->basicTests();
        $this->basicInertiaTests();
        $this->inertiaTeamTests();
    }
}
