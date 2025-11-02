@aware([
    'checkIcon' => 'check',
    'checkIconClass' => '',
    'searchable' => false
])

@props([
    'value' => null,
    'label' => null,
    'icon' => null,
    'iconClass' => null,
])

@php
    // if there no label provided (when the value is the same as label) give the slot the value's value
    $slot = filled($slot->__toString()) ? $slot->__toString() : $value;
@endphp

<li 
    tabindex="0"
    x-bind:data-value="@js($value)"
    x-bind:data-label="@js($slot)"

    x-show="isItemShown(@js($value))"
    
    x-on:mouseleave="$el.blur()"
    x-on:mouseenter="$el.focus()"
    
    x-bind:id="'option-' + getFilteredIndex(@js($value))"
    x-on:click="select(@js($value))"
    
    x-bind:class="{
        'bg-neutral-300 hover:bg-neutral-100': isFocused(@js($value)),
        '[&>[data-slot=icon]]:opacity-100': isSelected(@js($value)),
    }"
    role="option"
    data-slot="option"
    class="cursor-pointer focus:bg-neutral-100 px-3 py-0.5 rounded-[calc(var(--round)-var(--padding))] col-span-full grid grid-cols-subgrid items-center w-full self-center gap-x-2 text-[1rem]"
>
    <x-ui.icon 
        :name="$checkIcon"
        @class([
            'text-black z-10 place-self-center opacity-0 size-[1.15rem]',
            $checkIconClass,
        ])
    />
    @if (filled($icon))
        <x-ui.icon 
            :name="$icon"
            @class([
                'text-black z-10 pl-1.5',
                $iconClass
            ]) 
        />
    @endif
    <span class="col-start-3 text-start text-black">{{ $slot  }}</span>
</li>