@props([
    'label' => '',
    'description' => '',
    'error' => '',
    'required' => false,
    'disabled' => false,
    'checked' => false,
    'value' => '',
    'name' => '',
    'id' => '',
    'class' => '',
    'labelClass' => '',
    'descriptionClass' => '',
    'errorClass' => '',
])

@php
    $componentId = $id ?: 'checkbox-' . uniqid();
    $wireModel = $attributes->whereStartsWith('wire:model')->first();
    $xModel = $attributes->whereStartsWith('x-model')->first();
    
    $labelClasses = [
        'flex items-start gap-3 cursor-pointer',
        $labelClass
    ];
    
    $checkboxClasses = [
        'shrink-0 size-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500 focus:ring-2',
        'disabled:opacity-50 disabled:cursor-not-allowed',
        $class
    ];
    
    $descriptionClasses = [
        'text-sm text-gray-600 dark:text-gray-400',
        $descriptionClass
    ];
    
    $errorClasses = [
        'text-sm text-red-600 dark:text-red-400 mt-1',
        $errorClass
    ];
@endphp

<div class="w-full">
    <label @class($labelClasses) for="{{ $componentId }}">
        <input
            type="checkbox"
            id="{{ $componentId }}"
            name="{{ $name }}"
            value="{{ $value }}"
            @if($checked) checked @endif
            @if($disabled) disabled @endif
            @if($required) required @endif
            @if($wireModel) wire:model="{{ $wireModel }}" @endif
            @if($xModel) x-model="{{ $xModel }}" @endif
            @class($checkboxClasses)
            {{ $attributes->except(['wire:model', 'x-model', 'class', 'labelClass', 'descriptionClass', 'errorClass']) }}
        />
        
        <div class="flex-1">
            @if($label)
                <span class="text-sm font-medium text-slate-900 !text-slate-900" style="color: #0f172a !important;">
                    {{ $label }}
                    @if($required)
                        <span class="text-red-500 ml-1">*</span>
                    @endif
                </span>
            @endif
            
            @if($description)
                <p @class($descriptionClasses)>
                    {{ $description }}
                </p>
            @endif
        </div>
    </label>
    
    @if($error)
        <p @class($errorClasses)>
            {{ $error }}
        </p>
    @endif
</div>
