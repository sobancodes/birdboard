<div class="card !h-[300px]">
    <h3 class="py-4 pl-5 mb-3 -ml-5 text-xl font-bold border-l-4 border-blue-500">
        <a href="{{ $project->path() }}" class="text-black">{{ $project->title }}</a>
    </h3>
    <div class="text-gray-400">{{ \Illuminate\Support\Str::limit($project->description, 100) }}</div>
</div>
