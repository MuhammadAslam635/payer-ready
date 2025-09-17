<?php

namespace App\Livewire\Components;

use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

class Pagination extends Component
{
    use WithPagination;

    public $items;
    public $perPage = 15;
    public $showPerPageOptions = true;
    public $perPageOptions = [10, 15, 25, 50, 100];
    public $showPageNumbers = true;
    public $maxPageNumbers = 7;

    protected $listeners = ['refresh-pagination' => '$refresh'];

    public function mount($items = null, $perPage = 15)
    {
        $this->items = $items;
        $this->perPage = $perPage;
    }

    public function updatedPerPage()
    {
        $this->resetPage();
        $this->dispatch('per-page-changed', perPage: $this->perPage);
    }

    public function nextPage()
    {
        $this->nextPage();
    }

    public function previousPage()
    {
        $this->previousPage();
    }

    public function gotoPage($page)
    {
        $this->gotoPage($page);
    }

    public function getVisiblePages()
    {
        if (!$this->items instanceof LengthAwarePaginator) {
            return [];
        }

        $currentPage = $this->items->currentPage();
        $lastPage = $this->items->lastPage();
        $delta = floor($this->maxPageNumbers / 2);

        $range = [];
        $rangeWithDots = [];

        for ($i = max(2, $currentPage - $delta); $i <= min($lastPage - 1, $currentPage + $delta); $i++) {
            $range[] = $i;
        }

        if ($currentPage - $delta > 2) {
            $rangeWithDots[] = 1;
            $rangeWithDots[] = '...';
        } else {
            $rangeWithDots[] = 1;
        }

        $rangeWithDots = array_merge($rangeWithDots, $range);

        if ($currentPage + $delta < $lastPage - 1) {
            $rangeWithDots[] = '...';
            $rangeWithDots[] = $lastPage;
        } else {
            if ($lastPage > 1) {
                $rangeWithDots[] = $lastPage;
            }
        }

        return $rangeWithDots;
    }

    public function render()
    {
        return view('livewire.components.pagination');
    }
}
