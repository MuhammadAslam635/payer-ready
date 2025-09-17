<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\WithPagination;

class DataTable extends Component
{
    use WithPagination;

    public $columns = [];
    public $data = [];
    public $perPage = 15;
    public $sortBy = '';
    public $sortDirection = 'asc';
    public $searchQuery = '';
    public $filters = [];
    public $selectable = false;
    public $selectedItems = [];
    public $selectAll = false;
    public $actions = [];
    public $bulkActions = [];

    protected $listeners = [
        'refresh-table' => '$refresh',
        'search-updated' => 'updateSearch',
        'filters-updated' => 'updateFilters',
        'sort-updated' => 'updateSort'
    ];

    public function mount($columns = [], $data = [], $perPage = 15)
    {
        $this->columns = $columns;
        $this->data = $data;
        $this->perPage = $perPage;
    }

    public function updateSearch($query)
    {
        $this->searchQuery = $query;
        $this->resetPage();
    }

    public function updateFilters($filters)
    {
        $this->filters = $filters;
        $this->resetPage();
    }

    public function updateSort($sortBy, $direction)
    {
        $this->sortBy = $sortBy;
        $this->sortDirection = $direction;
        $this->resetPage();
    }

    public function sort($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function updatedSelectAll()
    {
        if ($this->selectAll) {
            $this->selectedItems = $this->getPaginatedData()->pluck('id')->toArray();
        } else {
            $this->selectedItems = [];
        }
    }

    public function updatedSelectedItems()
    {
        $this->selectAll = count($this->selectedItems) === $this->getPaginatedData()->count();
    }

    public function getPaginatedData()
    {
        $query = collect($this->data);

        // Apply search
        if ($this->searchQuery) {
            $query = $query->filter(function ($item) {
                foreach ($this->columns as $column) {
                    if (isset($column['searchable']) && $column['searchable'] && isset($item[$column['key']])) {
                        if (stripos($item[$column['key']], $this->searchQuery) !== false) {
                            return true;
                        }
                    }
                }
                return false;
            });
        }

        // Apply filters
        foreach ($this->filters as $key => $value) {
            if ($value) {
                $query = $query->filter(function ($item) use ($key, $value) {
                    return isset($item[$key]) && $item[$key] === $value;
                });
            }
        }

        // Apply sorting
        if ($this->sortBy) {
            $query = $query->sortBy($this->sortBy, SORT_REGULAR, $this->sortDirection === 'desc');
        }

        return $query;
    }

    public function getFormattedValue($item, $column)
    {
        $value = $item[$column['key']] ?? '';

        if (isset($column['format'])) {
            switch ($column['format']) {
                case 'date':
                    return $value ? \Carbon\Carbon::parse($value)->format('M j, Y') : '';
                case 'datetime':
                    return $value ? \Carbon\Carbon::parse($value)->format('M j, Y g:i A') : '';
                case 'currency':
                    return $value ? '$' . number_format($value, 2) : '';
                case 'boolean':
                    return $value ? 'Yes' : 'No';
                case 'badge':
                    $color = $column['badge_colors'][$value] ?? 'gray';
                    return "<span class='inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{$color}-100 text-{$color}-800'>{$value}</span>";
                default:
                    return $value;
            }
        }

        return $value;
    }

    public function executeAction($action, $itemId = null)
    {
        if ($itemId) {
            $this->dispatch('table-action', action: $action, itemId: $itemId);
        } else {
            $this->dispatch('table-action', action: $action, itemIds: $this->selectedItems);
        }
    }

    public function render()
    {
        $paginatedData = $this->getPaginatedData();
        $paginated = $paginatedData->forPage($this->page, $this->perPage);

        return view('livewire.components.data-table', [
            'paginatedData' => $paginated,
            'totalItems' => $paginatedData->count()
        ]);
    }
}
