@props(['breadcrumbs' => []])

@if(!empty($breadcrumbs))
    <nav class="flex mb-4 sm:mb-6 overflow-x-auto" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 sm:space-x-2 md:space-x-3 min-w-max">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-xs sm:text-sm font-medium text-slate-700 hover:text-blue-600" wire:navigate>
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>
                    <span class="hidden sm:inline">Dashboard</span>
                    <span class="sm:hidden">Home</span>
                </a>
            </li>

            @foreach($breadcrumbs as $index => $breadcrumb)
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 md:w-6 md:h-6 text-slate-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                        @if(isset($breadcrumb['url']) && $index < count($breadcrumbs) - 1)
                            <a href="{{ $breadcrumb['url'] }}" class="ml-1 text-xs sm:text-sm font-medium text-slate-700 hover:text-blue-600 md:ml-2 truncate max-w-20 sm:max-w-none" wire:navigate>
                                {{ $breadcrumb['title'] }}
                            </a>
                        @else
                            <span class="ml-1 text-xs sm:text-sm font-medium text-slate-500 md:ml-2 truncate max-w-20 sm:max-w-none" aria-current="page">
                                {{ $breadcrumb['title'] }}
                            </span>
                        @endif
                    </div>
                </li>
            @endforeach
        </ol>
    </nav>
@endif
