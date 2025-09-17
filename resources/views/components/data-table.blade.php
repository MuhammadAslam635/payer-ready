@props([
    'columns' => [],
    'data' => [],
    'perPage' => 15,
    'sortable' => true,
    'selectable' => false,
    'actions' => [],
    'bulkActions' => []
])

@php
    $currentPage = request()->get('page', 1);
    $offset = ($currentPage - 1) * $perPage;
    $paginatedData = collect($data)->slice($offset, $perPage);
    $totalPages = ceil(collect($data)->count() / $perPage);
@endphp

<div class="bg-white shadow overflow-hidden sm:rounded-md">
    <!-- Table Header -->
    <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ $title ?? 'Data Table' }}
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    {{ $description ?? 'A list of all items' }}
                </p>
            </div>
            @if(isset($actions) && count($actions) > 0)
                <div class="flex space-x-2">
                    @foreach($actions as $action)
                        <button onclick="{{ $action['onclick'] ?? '' }}"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            @if(isset($action['icon']))
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $action['icon'] }}"/>
                                </svg>
                            @endif
                            {{ $action['label'] }}
                        </button>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Bulk Actions -->
    @if($selectable && count($bulkActions) > 0)
        <div class="bg-gray-50 px-4 py-3 border-b border-gray-200" id="bulk-actions" style="display: none;">
            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-700" id="selected-count">0 items selected</span>
                @foreach($bulkActions as $action)
                    <button onclick="{{ $action['onclick'] ?? '' }}"
                            class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        {{ $action['label'] }}
                    </button>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    @if($selectable)
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" id="select-all" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </th>
                    @endif
                    @foreach($columns as $column)
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            @if($sortable && isset($column['sortable']) && $column['sortable'])
                                <button onclick="sortTable('{{ $column['key'] }}')" class="group inline-flex items-center">
                                    {{ $column['label'] }}
                                    <svg class="ml-2 h-4 w-4 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                    </svg>
                                </button>
                            @else
                                {{ $column['label'] }}
                            @endif
                        </th>
                    @endforeach
                    @if(count($actions) > 0)
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($paginatedData as $index => $item)
                    <tr class="hover:bg-gray-50">
                        @if($selectable)
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" class="item-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                       value="{{ $item['id'] ?? $index }}">
                            </td>
                        @endif
                        @foreach($columns as $column)
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if(isset($column['format']))
                                    @switch($column['format'])
                                        @case('date')
                                            {{ $item[$column['key']] ? \Carbon\Carbon::parse($item[$column['key']])->format('M j, Y') : '' }}
                                            @break
                                        @case('datetime')
                                            {{ $item[$column['key']] ? \Carbon\Carbon::parse($item[$column['key']])->format('M j, Y g:i A') : '' }}
                                            @break
                                        @case('currency')
                                            {{ $item[$column['key']] ? '$' . number_format($item[$column['key']], 2) : '' }}
                                            @break
                                        @case('boolean')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item[$column['key']] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $item[$column['key']] ? 'Yes' : 'No' }}
                                            </span>
                                            @break
                                        @case('badge')
                                            @php
                                                $badgeColor = $column['badge_colors'][$item[$column['key']]] ?? 'gray';
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $badgeColor }}-100 text-{{ $badgeColor }}-800">
                                                {{ $item[$column['key']] }}
                                            </span>
                                            @break
                                        @default
                                            {{ $item[$column['key']] ?? '' }}
                                    @endswitch
                                @else
                                    {{ $item[$column['key']] ?? '' }}
                                @endif
                            </td>
                        @endforeach
                        @if(count($actions) > 0)
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    @foreach($actions as $action)
                                        <button onclick="{{ $action['onclick'] ?? '' }}"
                                                class="text-blue-600 hover:text-blue-900 {{ $action['class'] ?? '' }}">
                                            @if(isset($action['icon']))
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $action['icon'] }}"/>
                                                </svg>
                                            @else
                                                {{ $action['label'] }}
                                            @endif
                                        </button>
                                    @endforeach
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) + ($selectable ? 1 : 0) + (count($actions) > 0 ? 1 : 0) }}" class="px-6 py-12 text-center text-sm text-gray-500">
                            No data available
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($totalPages > 1)
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="flex-1 flex justify-between sm:hidden">
                @if($currentPage > 1)
                    <a href="?page={{ $currentPage - 1 }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Previous
                    </a>
                @endif
                @if($currentPage < $totalPages)
                    <a href="?page={{ $currentPage + 1 }}" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Next
                    </a>
                @endif
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Showing
                        <span class="font-medium">{{ $offset + 1 }}</span>
                        to
                        <span class="font-medium">{{ min($offset + $perPage, collect($data)->count()) }}</span>
                        of
                        <span class="font-medium">{{ collect($data)->count() }}</span>
                        results
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        @for($i = 1; $i <= $totalPages; $i++)
                            @if($i == $currentPage)
                                <span class="relative inline-flex items-center px-4 py-2 border border-blue-500 bg-blue-50 text-sm font-medium text-blue-600">
                                    {{ $i }}
                                </span>
                            @else
                                <a href="?page={{ $i }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                    {{ $i }}
                                </a>
                            @endif
                        @endfor
                    </nav>
                </div>
            </div>
        </div>
    @endif
</div>

@if($selectable)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('select-all');
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        const bulkActions = document.getElementById('bulk-actions');
        const selectedCount = document.getElementById('selected-count');

        function updateBulkActions() {
            const checkedItems = document.querySelectorAll('.item-checkbox:checked');
            const count = checkedItems.length;

            if (count > 0) {
                bulkActions.style.display = 'block';
                selectedCount.textContent = count + ' item' + (count > 1 ? 's' : '') + ' selected';
            } else {
                bulkActions.style.display = 'none';
            }
        }

        selectAllCheckbox.addEventListener('change', function() {
            itemCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActions();
        });

        itemCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;
                selectAllCheckbox.checked = checkedCount === itemCheckboxes.length;
                selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < itemCheckboxes.length;
                updateBulkActions();
            });
        });
    });
</script>
@endif
