<x-app-layout>

    @if(session()->has('message'))
        <div class="mt-2 p-4 mb-2 text-sm text-green-800 rounded-lg bg-green-50 " role="alert">
            <span class="font-medium">{{ session('message') }}</span>
        </div>
    @endif

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Locações') }}
        </h2>
    </x-slot>

    <div class="w-full">
        <livewire:locacoes.show />
    </div>

</x-app-layout>
