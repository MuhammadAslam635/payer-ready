<?php

namespace App\Livewire\OrganizationAdmin\SupportTickets;

use App\Models\SupportTicket;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Enums\UserType;

#[Title('Support Tickets')]
#[Layout('layouts.dashboard')]
class AllSupportTicketsComponent extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $priorityFilter = '';
    public $doctorFilter = '';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'priorityFilter' => ['except' => ''],
        'doctorFilter' => ['except' => ''],
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

    public function updatingDoctorFilter()
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
        $user = Auth::user();
        
        // Get all doctor IDs created by this organization admin
        $organizationDoctorIds = User::where('org_id', $user->id)
            ->where('user_type', UserType::DOCTOR)
            ->pluck('id');

        return SupportTicket::with(['user.parentOrganization', 'assignedUser'])
            ->whereIn('user_id', $organizationDoctorIds)
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
            ->when($this->doctorFilter, function ($query) {
                $query->where('user_id', $this->doctorFilter);
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);
    }

    public function getDoctorsProperty()
    {
        $user = Auth::user();
        
        return User::where('org_id', $user->id)
            ->where('user_type', UserType::DOCTOR)
            ->where('is_active', true)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
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
        $user = Auth::user();
        
        // Get all doctor IDs created by this organization admin
        $organizationDoctorIds = User::where('org_id', $user->id)
            ->where('user_type', UserType::DOCTOR)
            ->pluck('id');
        
        return [
            'total' => SupportTicket::whereIn('user_id', $organizationDoctorIds)->count(),
            'open' => SupportTicket::whereIn('user_id', $organizationDoctorIds)->where('status', 'open')->count(),
            'in_progress' => SupportTicket::whereIn('user_id', $organizationDoctorIds)->where('status', 'in_progress')->count(),
            'resolved' => SupportTicket::whereIn('user_id', $organizationDoctorIds)->where('status', 'resolved')->count(),
            'closed' => SupportTicket::whereIn('user_id', $organizationDoctorIds)->where('status', 'closed')->count(),
        ];
    }

    public function render()
    {
        return view('livewire.organization-admin.support-tickets.all-support-tickets-component', [
            'tickets' => $this->tickets,
            'doctors' => $this->doctors,
            'stats' => $this->getStats(),
        ]);
    }
}
