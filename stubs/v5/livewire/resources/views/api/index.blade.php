<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('API Tokens') }}
        </h2>
    </x-slot>

    @livewire('api.api-token-manager')
</x-app-layout>