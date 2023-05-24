<x-app-layout>
    <x-slot name="header">
        <div class="flex items-end justify-between">
            <p class="text-base font-normal leading-tight text-gray-400">
                <a href="/projects">{{ __('My Projects') }}</a> / {{ $project->title }}
            </p>

            <a href="{{ route('projects.create') }}" type="submit" class="button">
                {{ __('New Project') }}
            </a>
        </div>
    </x-slot>

    <main class="px-4 mx-auto mt-5 max-w-7xl sm:px-6 lg:px-8">
        <div class="-mx-3 lg:flex">
            <div class="px-3 mb-4 lg:w-3/4">

                <div class="mb-6 space-y-3">
                    <h2 class="mb-3 text-lg font-normal leading-tight text-gray-400">
                        {{ __('Tasks') }}
                    </h2>

                    @foreach ($project->tasks as $task)
                        <div class="card">
                            <form method="POST" action="{{ $task->path() }}">
                                @csrf
                                @method('PATCH')
                                <div class="flex items-center ">
                                    <input class="w-full outline-none {{ $task->completed ? 'text-gray-400' : '' }}" name="body" value="{{ $task->body }}" />
                                    <input class="border-gray-400 rounded-sm" name="completed" type="checkbox" onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
                                </div>
                            </form>
                        </div>
                    @endforeach
                    <div class="card">
                        <form action="{{ $project->path() . '/tasks' }}" method="post">
                            @csrf
                            <input name="body" placeholder="{{ __('Add a new task...') }}" class="w-full" />
                        </form>
                    </div>
                </div>

                <div>
                    <h2 class="mb-3 text-lg font-normal leading-tight text-gray-400">
                        {{ __('General Notes') }}
                    </h2>

                    <textarea class="w-full h-[200px] border-none rounded-md">Lorem ipsum</textarea>
                </div>
            </div>
            <div class="px-3 lg:w-1/4">
                @include('projects.card')
            </div>
        </div>
    </main>
</x-app-layout>
