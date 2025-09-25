@php
    $indicatorClasses = [
        'relative',
        'shrink-0 size-[1.125rem] rounded border-gray-300 text-sm shadow-xs bg-white dark:bg-white/5',
        "after:content-['✓'] after:absolute after:text-xs after:font-bold after:top-1/2 after:left-1/2 after:-translate-1/2 after:text-white after:hidden",
        'border border-gray-300 dark:border-white/10',
        
    ];
@endphp

<div @class($indicatorClasses) data-slot="checkbox-item-indicator"></div>