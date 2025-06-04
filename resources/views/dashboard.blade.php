<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if(session()->has('error'))
        <div class="mt-2 p-4 mb-2 text-sm text-red-800 rounded-lg bg-red-50 " role="alert">
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    @if(session()->has('message'))
        <div class="mt-2 p-4 mb-2 text-sm text-green-800 rounded-lg bg-green-50 " role="alert">
            <span class="font-medium">{{ session('message') }}</span>
        </div>
    @endif

    <div class="py-6">
        <div class="p-6 text-gray-900">
            <livewire:carros.show/>
        </div>
    </div>

</x-app-layout>
