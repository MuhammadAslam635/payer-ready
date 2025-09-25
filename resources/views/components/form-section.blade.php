@props(['submit'])

<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-0']) }}>
    <x-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-section-title>

    <div class="mt-5 md:mt-0 md:col-span-2 w-full">
        <form wire:submit="{{ $submit }}">
            <div class="p-4  bg-white dark:bg-gray-800 sm:pl-6 sm:pr-6 sm:py-6 shadow w-full {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                {{ $form }}
            </div>

            @if (isset($actions))
                <div class="flex items-center justify-end pl-4 pr-0 py-3 bg-gray-50 dark:bg-gray-800 text-end sm:pl-6 sm:pr-0 shadow sm:rounded-bl-md sm:rounded-br-md">
                    {{ $actions }}
                </div>
            @endif
        </form>
    </div>
</div>
