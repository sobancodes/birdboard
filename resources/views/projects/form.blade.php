{{-- title --}}
<div class="grid grid-cols-3 gap-6">
    <div class="col-span-3 sm:col-span-2">
        <label for="title" class="block text-sm font-medium leading-6 text-gray-900">
            {{ __('Title') }}
        </label>
        <div class="flex mt-2 rounded-md">
            <input value="{{ $project->title ?? '' }}" type="text" name="title" id="title" autocomplete="title"
                class="block w-full max-w-lg rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:max-w-xs sm:text-sm sm:leading-6">
        </div>
    </div>
</div>
{{-- description --}}
<div>
    <label for="description" class="block text-sm font-medium leading-6 text-gray-900">{{ __('Description') }}</label>
    <div class="mt-2">
        <textarea id="description" name="description" rows="3"
            class="mt-1 block w-full rounded-md border-0 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:py-1.5 sm:text-sm sm:leading-6"
            placeholder="Project Description">{{ $project->description ?? '' }}</textarea>
    </div>
    <p class="mt-2 text-sm text-gray-500">{{ __('Add brief description for your project') }}</p>
</div>
{{-- submit --}}
<button type="submit" class="button">
    <svg class="-ml-0.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
            clip-rule="evenodd" />
    </svg>
    {{ !isset($project) ? __('Create') : __('Update') }}
</button>

@if ($errors->any())
    <div class="text-white bg-red-500 rounded-md errors">
        @foreach ($errors->all() as $error)
            <div class="p-2 text-sm">
                {{ $error }}
            </div>
        @endforeach
    </div>
@endif
