<?php

namespace App\Livewire\Components;

use Livewire\Component;

class SearchFilter extends Component
{
    public $searchQuery = '';
    public $filters = [];
    public $sortBy = '';
    public $sortDirection = 'asc';
    public $showFilters = false;

    protected $listeners = [
        'reset-filters' => 'resetFilters',
        'apply-filters' => 'applyFilters'
    ];

    public function mount($filters = [], $sortBy = '', $sortDirection = 'asc')
    {
        $this->filters = $filters;
        $this->sortBy = $sortBy;
        $this->sortDirection = $sortDirection;
    }

    public function updatedSearchQuery()
    {
        $this->dispatch('search-updated', query: $this->searchQuery);
    }

    public function updatedFilters()
    {
        $this->dispatch('filters-updated', filters: $this->filters);
    }

    public function updatedSortBy()
    {
        $this->dispatch('sort-updated', sortBy: $this->sortBy, direction: $this->sortDirection);
    }

    public function updatedSortDirection()
    {
        $this->dispatch('sort-updated', sortBy: $this->sortBy, direction: $this->sortDirection);
    }

    public function toggleSort($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        
        $this->dispatch('sort-updated', sortBy: $this->sortBy, direction: $this->sortDirection);
    }

    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }

    public function resetFilters()
    {
        $this->searchQuery = '';
        $this->filters = [];
        $this->sortBy = '';
        $this->sortDirection = 'asc';
        $this->showFilters = false;
        
        $this->dispatch('filters-reset');
    }

    public function applyFilters()
    {
        $this->dispatch('filters-applied', [
            'search' => $this->searchQuery,
            'filters' => $this->filters,
            'sortBy' => $this->sortBy,
            'sortDirection' => $this->sortDirection
        ]);
    }

    public function clearSearch()
    {
        $this->searchQuery = '';
        $this->dispatch('search-updated', query: '');
    }

    public function clearFilter($key)
    {
        unset($this->filters[$key]);
        $this->dispatch('filters-updated', filters: $this->filters);
    }

    public function render()
    {
        return view('livewire.components.search-filter');
    }
}
