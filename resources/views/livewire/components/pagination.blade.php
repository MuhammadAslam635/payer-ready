@if($items instanceof \Illuminate\Pagination\LengthAwarePaginator && $items->hasPages())
    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
        <!-- Per page selector -->
        @if($showPerPageOptions)
            <div class="flex items-center">
                <p class="text-sm text-gray-700 mr-2">Show</p>
                <select wire:model.live="perPage" class="border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    @foreach($perPageOptions as $option)
                        <option value="{{ $option }}">{{ $option }}</option>
                    @endforeach
                </select>
                <p class="text-sm text-gray-700 ml-2">per page</p>
            </div>
        @else
            <div class="flex-1 flex justify-between sm:hidden">
                <span class="text-sm text-gray-700">
                    Showing {{ $items->firstItem() }} to {{ $items->lastItem() }} of {{ $items->total() }} results
                </span>
            </div>
        @endif

        <!-- Pagination controls -->
        <div class="flex-1 flex justify-between sm:justify-end">
            <!-- Mobile pagination -->
            <div class="flex sm:hidden">
                @if($items->onFirstPage())
                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-not-allowed rounded-l-md">
                        Previous
                    </span>
                @else
                    <button wire:click="previousPage" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-l-md">
                        Previous
                    </button>
                @endif

                @if($items->hasMorePages())
                    <button wire:click="nextPage" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-r-md">
                        Next
                    </button>
                @else
                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-not-allowed rounded-r-md">
                        Next
                    </span>
                @endif
            </div>

            <!-- Desktop pagination -->
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Showing
                        <span class="font-medium">{{ $items->firstItem() }}</span>
                        to
                        <span class="font-medium">{{ $items->lastItem() }}</span>
                        of
                        <span class="font-medium">{{ $items->total() }}</span>
                        results
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <!-- Previous button -->
                        @if($items->onFirstPage())
                            <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-not-allowed">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        @else
                            <button wire:click="previousPage" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        @endif

                        <!-- Page numbers -->
                        @if($showPageNumbers)
                            @foreach($this->getVisiblePages() as $page)
                                @if($page === '...')
                                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                                        ...
                                    </span>
                                @elseif($page === $items->currentPage())
                                    <span class="relative inline-flex items-center px-4 py-2 border border-blue-500 bg-blue-50 text-sm font-medium text-blue-600">
                                        {{ $page }}
                                    </span>
                                @else
                                    <button wire:click="gotoPage({{ $page }})" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        {{ $page }}
                                    </button>
                                @endif
                            @endforeach
                        @endif

                        <!-- Next button -->
                        @if($items->hasMorePages())
                            <button wire:click="nextPage" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        @else
                            <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 cursor-not-allowed">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endif
