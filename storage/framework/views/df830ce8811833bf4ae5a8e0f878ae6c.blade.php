<?php extract((new \Illuminate\Support\Collection($attributes->getAttributes()))->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
@props(['dataSlot','class','ariaHidden'])
<x-heroicons::outline.eye :data-slot="$dataSlot" :class="$class" :aria-hidden="$ariaHidden" >

{{ $slot ?? "" }}
</x-heroicons::outline.eye>