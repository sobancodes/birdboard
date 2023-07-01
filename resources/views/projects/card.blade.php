<div class="card !h-[300px] flex flex-col justify-between">
    <header>
        <h3 class="py-4 pl-5 mb-3 -ml-5 text-xl font-bold border-l-4 border-blue-500">
            <a href="{{ $project->path() }}" class="text-black">{{ $project->title }}</a>
        </h3>
        <div class="text-gray-400">{{ \Illuminate\Support\Str::limit($project->description, 100) }}</div>
    </header>

    <footer>
        @can('manage', $project)
            <form method="POST" action="{{ $project->path() }}" class="text-right">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500">
                    {{ __('Delete') }}
                </button>
            </form>
        @endcan
    </footer>
</div>
