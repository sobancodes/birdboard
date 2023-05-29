<div class="px-3 mt-3 card space-y-1.5">
    @foreach ($project->activity as $activity)
        <li class="flex items-center justify-between text-sm list-none">
            <span class="w-10/12">
                @include("projects.activity.{$activity->description}")
            </span>
            <span class="flex-none text-xs text-gray-400">{{ $activity->created_at->diffForHumans(null, true) }}</span>
        </li>
    @endforeach
</div>
