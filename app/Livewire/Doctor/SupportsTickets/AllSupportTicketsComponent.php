<?php

namespace App\Livewire\Doctor\SupportsTickets;

use App\Models\SupportTicket;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Title('Support tickets')]
#[Layout('layouts.dashboard')]
class AllSupportTicketsComponent extends Component
{
     use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $priorityFilter = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'priorityFilter' => ['except' => ''],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingPriorityFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function getTicketsProperty()
    {
        return SupportTicket::with(['assignedUser'])
            ->where('user_id', Auth::id())
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('ticket_number', 'like', '%' . $this->search . '%')
                      ->orWhere('subject', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->priorityFilter, function ($query) {
                $query->where('priority', $this->priorityFilter);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);
    }

    public function getStatusColor($status)
    {
        return match($status) {
            'open' => 'bg-blue-100 text-blue-800',
            'in_progress' => 'bg-yellow-100 text-yellow-800',
            'resolved' => 'bg-green-100 text-green-800',
            'closed' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getPriorityColor($priority)
    {
        return match($priority) {
            'low' => 'bg-green-100 text-green-800',
            'medium' => 'bg-yellow-100 text-yellow-800',
            'high' => 'bg-orange-100 text-orange-800',
            'urgent' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getStats()
    {
        $userId = Auth::id();
        
        return [
            'total' => SupportTicket::where('user_id', $userId)->count(),
            'open' => SupportTicket::where('user_id', $userId)->where('status', 'open')->count(),
            'in_progress' => SupportTicket::where('user_id', $userId)->where('status', 'in_progress')->count(),
            'resolved' => SupportTicket::where('user_id', $userId)->where('status', 'resolved')->count(),
            'closed' => SupportTicket::where('user_id', $userId)->where('status', 'closed')->count(),
        ];
    }
    public function render()
    {
        return view('livewire.doctor.supports-tickets.all-support-tickets-component', [
            'tickets' => $this->tickets,
            'stats' => $this->getStats(),
        ]);
    }
}
