<?php

namespace App\Livewire\SuperAdmin\Tickets;

use App\Models\SupportTicket;
use App\Models\User;
use App\Enums\UserType;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout as AttributesLayout;
use App\Traits\HasToast;

#[AttributesLayout('layouts.dashboard')]
class AdminViewAllTicketsComponent extends Component
{
    use WithPagination, HasToast;

    public $search = '';
    public $statusFilter = '';
    public $priorityFilter = '';
    public $categoryFilter = '';
    public $assignedFilter = '';
    public $perPage = 15;

    // Available filter options
    public $statusOptions = [
        'open' => 'Open',
        'in_progress' => 'In Progress', 
        'resolved' => 'Resolved',
        'closed' => 'Closed'
    ];

    public $priorityOptions = [
        'low' => 'Low',
        'medium' => 'Medium',
        'high' => 'High',
        'urgent' => 'Urgent'
    ];

    public $categoryOptions = [
        'technical' => 'Technical',
        'billing' => 'Billing',
        'account' => 'Account',
        'general' => 'General'
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'priorityFilter' => ['except' => ''],
        'categoryFilter' => ['except' => ''],
        'assignedFilter' => ['except' => ''],
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

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatingAssignedFilter()
    {
        $this->resetPage();
    }

    /**
     * Update ticket status
     */
    public function updateTicketStatus($ticketId, $newStatus)
    {
        try {
            $ticket = SupportTicket::findOrFail($ticketId);
            $oldStatus = $ticket->status;
            
            $ticket->update([
                'status' => $newStatus,
                'resolved_at' => $newStatus === 'resolved' ? now() : null
            ]);

            $this->toastSuccess("Ticket #{$ticket->ticket_number} status updated from {$oldStatus} to {$newStatus}");
        } catch (\Exception $e) {
            $this->toastError('Failed to update ticket status: ' . $e->getMessage());
        }
    }

    /**
     * Update ticket priority
     */
    public function updateTicketPriority($ticketId, $newPriority)
    {
        try {
            $ticket = SupportTicket::findOrFail($ticketId);
            $oldPriority = $ticket->priority;
            
            $ticket->update(['priority' => $newPriority]);

            $this->toastSuccess("Ticket #{$ticket->ticket_number} priority updated from {$oldPriority} to {$newPriority}");
        } catch (\Exception $e) {
            $this->toastError('Failed to update ticket priority: ' . $e->getMessage());
        }
    }

    /**
     * Assign ticket to user
     */
    public function assignTicket($ticketId, $userId)
    {
        try {
            $ticket = SupportTicket::findOrFail($ticketId);
            $user = User::findOrFail($userId);
            
            $ticket->update(['assigned_to' => $userId]);

            $this->toastSuccess("Ticket #{$ticket->ticket_number} assigned to {$user->name}");
        } catch (\Exception $e) {
            $this->toastError('Failed to assign ticket: ' . $e->getMessage());
        }
    }

    /**
     * Unassign ticket
     */
    public function unassignTicket($ticketId)
    {
        try {
            $ticket = SupportTicket::findOrFail($ticketId);
            $ticket->update(['assigned_to' => null]);

            $this->toastSuccess("Ticket #{$ticket->ticket_number} unassigned");
        } catch (\Exception $e) {
            $this->toastError('Failed to unassign ticket: ' . $e->getMessage());
        }
    }

    /**
     * Get filtered tickets
     */
    public function getTickets()
    {
        $query = SupportTicket::with(['user', 'assignedUser'])
            ->orderBy('created_at', 'desc');

        // Apply search filter
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('ticket_number', 'like', '%' . $this->search . '%')
                  ->orWhere('subject', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function ($userQuery) {
                      $userQuery->where('name', 'like', '%' . $this->search . '%')
                               ->orWhere('email', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Apply status filter
        if (!empty($this->statusFilter)) {
            $query->where('status', $this->statusFilter);
        }

        // Apply priority filter
        if (!empty($this->priorityFilter)) {
            $query->where('priority', $this->priorityFilter);
        }

        // Apply category filter
        if (!empty($this->categoryFilter)) {
            $query->where('category', $this->categoryFilter);
        }

        // Apply assigned filter
        if (!empty($this->assignedFilter)) {
            if ($this->assignedFilter === 'unassigned') {
                $query->whereNull('assigned_to');
            } else {
                $query->where('assigned_to', $this->assignedFilter);
            }
        }

        return $query->paginate($this->perPage);
    }

    /**
     * Get assignable users (admins and coordinators)
     */
    public function getAssignableUsers()
    {
        return User::whereIn('user_type', [
            UserType::SUPER_ADMIN,
            UserType::COORDINATOR,
            UserType::ORGANIZATION_ADMIN,
            UserType::ORGANIZATION_COORDINATOR
        ])
        ->where('is_active', true)
        ->orderBy('name')
        ->get();
    }

    /**
     * Get priority CSS class
     */
    public function getPriorityClass($priority)
    {
        return match($priority) {
            'low' => 'bg-green-100 text-green-800',
            'medium' => 'bg-yellow-100 text-yellow-800',
            'high' => 'bg-orange-100 text-orange-800',
            'urgent' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    /**
     * Get status CSS class
     */
    public function getStatusClass($status)
    {
        return match($status) {
            'open' => 'bg-blue-100 text-blue-800',
            'in_progress' => 'bg-yellow-100 text-yellow-800',
            'resolved' => 'bg-green-100 text-green-800',
            'closed' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    public function render()
    {
        return view('livewire.super-admin.tickets.admin-view-all-tickets-component', [
            'supportTickets' => $this->getTickets(),
            'assignableUsers' => $this->getAssignableUsers(),
            'statusOptions' => $this->statusOptions,
            'priorityOptions' => $this->priorityOptions,
            'categoryOptions' => $this->categoryOptions,
        ]);
    }
}
