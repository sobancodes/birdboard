<x-app-layout>
    <x-slot name="header">
        <div class="flex items-end justify-between">
            <h2 class="font-normal text-base text-gray-400 leading-tight">
                {{ __('My Projects') }}
            </h2>

            <a href="{{ route('projects.create') }}" type="submit" class="button">
                {{ __('Add Project') }}
            </a>
        </div>
    </x-slot>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-5">
        <div class="lg:flex lg:flex-wrap -mx-3">
            @forelse ($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">
                <div class="bg-white rounded-lg shadow-sm h-[200px] p-5">
                    <h3 class="font-bold text-xl py-4 border-l-4 border-blue-500 mb-3 -ml-5 pl-5">
                        <a href="{{ $project->path() }}" class="text-black">{{ $project->title }}</a>
                    </h3>
                    <div class="text-gray-400">{{ \Illuminate\Support\Str::limit($project->description, 100) }}</div>
                </div>
            </div>

            @empty
            <div class="text-center relative bg-white py-12 px-4 rounded">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                </svg>
                <h3 class="mt-2 text-sm font-semibold text-gray-900">No projects</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new project.</p>
                <div class="mt-6">
                    <a href="{{ route('projects.create') }}" type="button" class="button">
                        <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                        </svg>
                        {{ __('New Project') }}
                    </a>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</x-app-layout>