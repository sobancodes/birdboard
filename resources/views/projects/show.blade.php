<x-app-layout>
    <x-slot name="header">
        <div class="flex items-end justify-between">
            <p class="text-base font-normal leading-tight text-gray-400">
                <a href="/projects">{{ __('My Projects') }}</a> / {{ $project->title }}
            </p>

            <div class="flex items-center space-x-2">
                @foreach ($project->members as $member)
                    <img src="https://gravatar.com/avatar/{{ md5($member->email) }}?s=60" alt="{{ $member->name }}"
                        class="rounded-full w-8">
                @endforeach

                <img src="https://gravatar.com/avatar/{{ md5($project->owner->email) }}?s=60"
                    alt="{{ $project->owner->name }}" class="rounded-full w-8">

                <a href="{{ $project->path() . '/edit' }}" type="submit" class="button">
                    {{ __('Edit Project') }}
                </a>
            </div>
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
                                    <input class="w-full outline-none {{ $task->completed ? 'text-gray-400' : '' }}"
                                        name="body" value="{{ $task->body }}" />
                                    <input class="border-gray-400 rounded-sm" name="completed" type="checkbox"
                                        onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
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
                    <form method="POST" action="{{ $project->path() }}">
                        @method('PATCH')
                        @csrf
                        <textarea class="w-full h-[200px] border-none rounded-md" name="notes"
                            placeholder="{{ __('Anything special you\'d like to make a note of?') }}">{{ $project->notes }}</textarea>
                        <button type="submit" class="mt-2 button">{{ __('Update') }}</button>
                    </form>
                    @include('projects.errors')
                </div>
            </div>
            <div class="px-3 lg:w-1/4 lg:py-8">
                @include('projects.card')

                @include('projects.activity.card')

                @can('manage', $project)
                     @include('projects.invite')
                @endcan
            </div>
        </div>
    </main>
</x-app-layout>
