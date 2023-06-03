@if (count($activity->changes['after']) == 1)
    {{ __("{$activity->user->name}  updated the ") . key($activity->changes['after']) . ' of the project' }}
@else
    {{ __("{$activity->user->name} updated the project") }}
@endif
