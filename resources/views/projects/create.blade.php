<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="px-4 mx-auto mt-5 max-w-7xl sm:px-6 lg:px-8">
        <form action="{{ route('projects.store') }}" method="POST">
            @csrf

            <div class="sm:overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 space-y-6 bg-white sm:p-6">
                    <div>
                        <h3 class="mb-2 text-xl font-bold">{{ __('Create a Project') }}</h3>
                        <p class="text-xs text-gray-500">{{ __('Get start by creating a new project') }}</p>
                    </div>

                    @include('projects.form')
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
