<div class="card mt-3">
    <h3 class="py-4 pl-5 mb-3 -ml-5 text-xl font-bold border-l-4 border-blue-500">
        Invite a User
    </h3>

    <form method="POST" action="{{ $project->path() }}/invite" class="space-y-4">
        @csrf
        <input type="email" name="email" class="input" placeholder="you@example.com">
        <button type="submit" class="button">
            {{ __('Invite') }}
        </button>
    </form>

    @include('projects.errors', ['bag' => 'invitation'])
</div>