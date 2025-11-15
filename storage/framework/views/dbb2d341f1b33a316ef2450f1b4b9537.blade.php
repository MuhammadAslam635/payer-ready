<?php extract((new \Illuminate\Support\Collection($attributes->getAttributes()))->mapWithKeys(function ($value, $key) { return [Illuminate\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
@props(['dataSlot','class'])
<x-heroicons::outline.chat-bubble-left-right :data-slot="$dataSlot" :class="$class" >

{{ $slot ?? "" }}
</x-heroicons::outline.chat-bubble-left-right>