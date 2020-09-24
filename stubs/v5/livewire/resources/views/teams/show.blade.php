<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Team Settings') }}
        </h2>
    </x-slot>

    @livewire('teams.update-team-name-form', ['team' => $team])

    @livewire('teams.team-member-manager', ['team' => $team])

    @if (Gate::check('delete', $team) && ! $team->personal_team)
        <x-jet-section-border />

        @livewire('teams.delete-team-form', ['team' => $team])
    @endif
</x-app-layout>