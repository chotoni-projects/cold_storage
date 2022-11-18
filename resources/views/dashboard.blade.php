<x-app-layout>
    @include('layouts._temperature')
    @include('layouts._livechart')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

</x-app-layout>
