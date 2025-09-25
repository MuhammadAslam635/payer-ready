@props([
    'label' => '',
    'required' => false,
    'error' => '',
    'direction' => 'vertical',
    'disabled' => false,
    'variant' => 'default',
    'labelClass' => '',
    'indicator' => true,
    'name' => $attributes->whereStartsWith('wire:model')->first() ?? $attributes->whereStartsWith('x-model')->first(),
])

@php
    $componentId = $id ?? 'checkbox-group-' . uniqid();
    
    $labelClasses = ['text-gray-800 dark:text-gray-300 font-semibold mb-4 inline-block', $labelClass];
    
    $variantClass = [
        'space-y-2' => $direction === 'vertical',
        'flex gap-1 items-stretch' => $direction === 'horizontal',
        'bg-neutral-200 dark:bg-neutral-800 rounded-box w-fit p-1' => $variant === 'segmented',
        'p-1' => $variant === 'cards',
    ];
@endphp

<div
    x-data="{
        state: [],
        init() {
            this.$nextTick(() => {
                this.state = this.$root?._x_model?.get() || [];
            });
            
            this.$watch('state', (value) => {
                // Sync with Alpine state
                this.$root?._x_model?.set(value);
                 
                // Sync with Livewire state
                let wireModel = this?.$root.getAttributeNames().find(n => n.startsWith('wire:model'))
                 
                if(this.$wire && wireModel){
                    let prop = this.$root.getAttribute(wireModel)
                    this.$wire.set(prop, value, wireModel?.includes('.live'));
                }
            });
            
        },
        toggleValue(value) {
            if (this.state.includes(value)) {
                this.state = this.state.filter(item => item !== value);
            } else {
                this.state = [...this.state, value];
            }
        },
        isChecked(value) {
            return this.state.includes(value);
        }
    }"
    {{ $attributes->merge(['class' => 'w-full text-start']) }}
>
    @if($label)
        <label @class($labelClasses)>
            {{ $label }}
            @if($required)
                <span class="text-red-500 ml-1">*</span>
            @endif
        </label>
    @endif

    <div @class($variantClass)>
        {{ $slot }}
    </div>

    @if($error)
        <p class="text-red-500 text-sm mt-1">{{ $error }}</p>
    @endif
</div>