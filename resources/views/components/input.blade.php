@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'text-gray-900 bg-white border-gray-300 placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}>
