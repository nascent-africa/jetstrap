<?php

namespace NascentAfrica\Jetstrap\Tests\Unit\Console;

use Illuminate\Support\Facades\Artisan;
use NascentAfrica\Jetstrap\Console\InstallCommand;
use NascentAfrica\Jetstrap\Tests\TestCase;

class InstallCommandTest extends TestCase
{
    /** @test */
    public function livewire_swapped_without_error()
    {
        // Run the make command
        $this->artisan('jetstrap:swap livewire')
            ->expectsOutput('Bootstrap scaffolding swapped for livewire successfully.')
            ->expectsOutput('Please execute the "npm install && npm run dev" command to build your assets.')
            ->assertExitCode(0);
    }

    /** @test */
    public function inertia_swapped_without_error()
    {
        // Run the make command
        $this->artisan('jetstrap:swap inertia')
            ->expectsOutput('Bootstrap scaffolding swapped for inertia successfully.')
            ->expectsOutput('Please execute the "npm install && npm run dev" command to build your assets.')
            ->assertExitCode(0);
    }
}
