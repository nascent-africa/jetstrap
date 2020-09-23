<?php

namespace NascentAfrica\Jetstrap\Tests;

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
    }

    /** @test */
    public function inertia_swapped()
    {
        // Run the make command
        $this->artisan('jetstrap:swap inertia')
            ->expectsOutput('Bootstrap scaffolding swapped for inertia successfully.')
            ->expectsOutput('Please execute the "npm install && npm run dev" command to build your assets.')
            ->assertExitCode(0);
    }

    /** @test */
    public function livewire_swapped_with_teams()
    {
        // Run the make command
        $this->artisan('jetstrap:swap livewire --teams')
            ->expectsOutput('Bootstrap scaffolding swapped for livewire successfully.')
            ->expectsOutput('Please execute the "npm install && npm run dev" command to build your assets.')
            ->assertExitCode(0);
    }

    /** @test */
    public function inertia_swapped_teams()
    {
        // Run the make command
        $this->artisan('jetstrap:swap inertia --teams')
            ->expectsOutput('Bootstrap scaffolding swapped for inertia successfully.')
            ->expectsOutput('Please execute the "npm install && npm run dev" command to build your assets.')
            ->assertExitCode(0);
    }
}
