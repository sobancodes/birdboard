<div class="px-3 mt-3 card space-y-1.5">
    @foreach ($project->activity as $activity)
        <li class="flex items-center justify-between text-sm list-none">
            @include("projects.activity.{$activity->description}")
            <span class="text-xs text-gray-400">{{ $activity->created_at->diffForHumans(null, true) }}</span>
        </li>
    @endforeach
</div>
