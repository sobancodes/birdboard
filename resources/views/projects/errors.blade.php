<div class="space-y-2 mt-4">
    @foreach ($errors->{$bag ?? 'default'}->all() as $error)
        <p class="text-red-400">
            {{ $error }}
        </p>
    @endforeach
</div>
