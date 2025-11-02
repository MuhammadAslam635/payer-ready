<?php

namespace App\Livewire\OrganizationAdmin\SupportTickets;

use App\Models\SupportTicket;
use App\Models\User;
use App\Traits\HasToast;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use App\Enums\UserType;

#[Title("Create Support Ticket")]
#[Layout('layouts.dashboard')]
class CreateSupportTicketComponent extends Component
{
    use HasToast;
    use WithFileUploads;

    public $subject = '';
    public $description = '';
    public $priority = 'medium';
    public $category = 'general';
    public $attachments = [];
    public $isSubmitting = false;
    public $selectedDoctorId = '';
    public $doctors = [];

    protected $rules = [
        'subject' => 'required|string|max:255',
        'description' => 'required|string|max:2000',
        'priority' => 'required|in:low,medium,high,urgent',
        'category' => 'required|string|max:100',
        'selectedDoctorId' => 'required|exists:users,id',
        'attachments.*' => 'file|max:10240', // 10MB max per file
    ];

    protected $messages = [
        'subject.required' => 'Please enter a subject for your ticket.',
        'subject.max' => 'Subject cannot exceed 255 characters.',
        'description.required' => 'Please provide a description of your issue.',
        'description.max' => 'Description cannot exceed 2000 characters.',
        'priority.required' => 'Please select a priority level.',
        'category.required' => 'Please select a category.',
        'selectedDoctorId.required' => 'Please select a doctor for this ticket.',
        'selectedDoctorId.exists' => 'Selected doctor does not exist.',
        'attachments.*.max' => 'Each file must be less than 10MB.',
    ];

    public function mount()
    {
        $this->loadDoctors();
    }

    public function loadDoctors()
    {
        $user = Auth::user();
        
        // Get all doctors created by this organization admin
        $this->doctors = User::where('org_id', $user->id) // Changed from $user->org_id to $user->id
            ->where('user_type', UserType::DOCTOR)
            ->where('is_active', true)
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get();
    }

    public function submit()
    {
        $this->validate();

        $this->isSubmitting = true;

        try {
            // Handle file uploads
            $uploadedFiles = [];
            if (!empty($this->attachments)) {
                foreach ($this->attachments as $attachment) {
                    $path = $attachment->store('assets/support-attachments', 'public');
                    $uploadedFiles[] = [
                        'name' => $attachment->getClientOriginalName(),
                        'path' => $path,
                        'size' => $attachment->getSize(),
                        'type' => $attachment->getMimeType(),
                    ];
                }
            }

            // Generate unique ticket number
            $ticketNumber = 'TKT-' . strtoupper(Str::random(8));
            
            // Ensure ticket number is unique
            while (SupportTicket::where('ticket_number', $ticketNumber)->exists()) {
                $ticketNumber = 'TKT-' . strtoupper(Str::random(8));
            }

            // Create the support ticket for the selected doctor
            $ticket = SupportTicket::create([
                'ticket_number' => $ticketNumber,
                'user_id' => $this->selectedDoctorId, // Ticket is created for the doctor
                'subject' => $this->subject,
                'description' => $this->description,
                'priority' => $this->priority,
                'category' => $this->category,
                'status' => 'open',
            ]);

            // Create initial message if there are attachments
            if (!empty($uploadedFiles)) {
                $ticket->messages()->create([
                    'sender_id' => Auth::id(),
                    'message' => 'Support ticket created by organization admin with attachments.',
                    'message_type' => 'system',
                    'attachments' => $uploadedFiles,
                    'is_read' => false,
                ]);
            }

            $this->toastSuccess('Support ticket created successfully for doctor! Ticket #' . $ticketNumber);
            
            // Redirect to the chat page for the new ticket
            return redirect()->route('organization-admin.chat_support_tickets', $ticket->id);

        } catch (\Exception $e) {
            $this->toastError('Failed to create support ticket. Please try again.', $e->getMessage());
        } finally {
            $this->isSubmitting = false;
        }
    }

    public function removeAttachment($index)
    {
        unset($this->attachments[$index]);
        $this->attachments = array_values($this->attachments);
    }

    public function resetForm()
    {
        $this->reset(['subject', 'description', 'priority', 'category', 'attachments', 'selectedDoctorId']);
    }

    public function render()
    {
        return view('livewire.organization-admin.support-tickets.create-support-ticket-component');
    }
}
