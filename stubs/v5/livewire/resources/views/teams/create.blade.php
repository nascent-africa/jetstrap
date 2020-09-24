<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Create Team') }}
        </h2>
    </x-slot>

    @livewire('teams.create-team-form')
</x-app-layout>