<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-5">
        <form action="{{ route('projects.store') }}" method="POST">
            @csrf

            <div class="sm:overflow-hidden sm:rounded-md">
                <div class="space-y-6 bg-white px-4 py-5 sm:p-6">
                    <div>
                        <h3 class="font-bold text-xl mb-2">{{ __('Create a Project') }}</h3>
                        <p class="text-gray-500 text-xs">{{ __('Get start by creating a new project') }}</p>
                    </div>
                    <div class="grid grid-cols-3 gap-6">
                        <div class="col-span-3 sm:col-span-2">
                            <label for="title" class="block text-sm font-medium leading-6 text-gray-900">
                                {{ __('Title') }}
                            </label>
                            <div class="mt-2 flex rounded-md">
                                <input type="text" name="title" id="title" autocomplete="title" class="block w-full max-w-lg rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:max-w-xs sm:text-sm sm:leading-6">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium leading-6 text-gray-900">{{__('Description')}}</label>
                        <div class="mt-2">
                            <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-0 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:py-1.5 sm:text-sm sm:leading-6" placeholder="Project Description"></textarea>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">{{ __('Add brief description for your project') }}</p>
                    </div>
                    <button type="submit" class="button">
                        <svg class="-ml-0.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                        {{ __('Submit') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>