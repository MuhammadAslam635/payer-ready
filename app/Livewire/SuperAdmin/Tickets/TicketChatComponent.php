<?php

namespace App\Livewire\SuperAdmin\Tickets;

use App\Models\SupportTicket;
use App\Models\Message;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout as AttributesLayout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

#[AttributesLayout('layouts.dashboard')]
class TicketChatComponent extends Component
{
    use WithFileUploads;

    public $ticketId;
    public $ticket;
    public $messages;
    public $newMessage = '';
    public $attachments = [];
    public $isLoading = false;

    protected function rules(): array
    {
        return [
            'newMessage' => 'required|string|max:1000',
            'attachments.*' => 'file|max:10240', // 10MB max per file
        ];
    }

    protected function messages(): array
    {
        return [
            'newMessage.required' => 'Please enter a message.',
            'newMessage.max' => 'Message cannot exceed 1000 characters.',
            'attachments.*.max' => 'Each file must be less than 10MB.',
        ];
    }

    public function mount($supportTicketId)
    {
        $this->ticketId = $supportTicketId;
        $this->loadTicket();
        $this->loadMessages();
    }

    public function loadTicket()
    {
        $this->ticket = SupportTicket::with(['user', 'assignedUser'])
            ->findOrFail($this->ticketId);
    }

    public function loadMessages()
    {
        $this->messages = Message::with(['sender'])
            ->where('support_ticket_id', $this->ticketId)
            ->orderBy('created_at', 'asc')
            ->get();
        
        // Mark messages as read
        $this->markMessagesAsRead();
    }

    public function sendMessage()
    {
        $this->validate();

        $this->isLoading = true;

        try {
            // Handle file uploads
            $uploadedFiles = [];
            if (!empty($this->attachments)) {
                foreach ($this->attachments as $attachment) {
                    $path = $attachment->store('ticket-attachments', 'public');
                    $uploadedFiles[] = [
                        'name' => $attachment->getClientOriginalName(),
                        'path' => $path,
                        'size' => $attachment->getSize(),
                        'type' => $attachment->getMimeType(),
                    ];
                }
            }

            // Create the message
            Message::create([
                'support_ticket_id' => $this->ticketId,
                'sender_id' => Auth::id(),
                'message' => $this->newMessage,
                'message_type' => 'text',
                'attachments' => !empty($uploadedFiles) ? $uploadedFiles : null,
                'is_read' => false,
            ]);

            // Update ticket status if it's closed
            if ($this->ticket->status === 'closed') {
                $this->ticket->update(['status' => 'in_progress']);
            }

            // Reset form
            $this->reset(['newMessage', 'attachments']);
            
            // Reload messages
            $this->loadMessages();
            
            session()->flash('message', 'Message sent successfully!');

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to send message. Please try again.');
        } finally {
            $this->isLoading = false;
        }
    }

    public function markMessagesAsRead()
    {
        Message::where('support_ticket_id', $this->ticketId)
            ->where('sender_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
    }

    public function downloadAttachment($messageId, $attachmentIndex)
    {
        $message = Message::findOrFail($messageId);
        
        if (!$message->attachments || !isset($message->attachments[$attachmentIndex])) {
            session()->flash('error', 'Attachment not found.');
            return;
        }

        $attachment = $message->attachments[$attachmentIndex];
        
        if (!Storage::disk('public')->exists($attachment['path'])) {
            session()->flash('error', 'File not found.');
            return;
        }

        return Storage::disk('public')->download($attachment['path'], $attachment['name']);
    }

    public function updateTicketStatus($status)
    {
        $validStatuses = ['open', 'in_progress', 'resolved', 'closed'];
        
        if (!in_array($status, $validStatuses)) {
            session()->flash('error', 'Invalid status.');
            return;
        }

        $this->ticket->update([
            'status' => $status,
            'resolved_at' => $status === 'resolved' ? now() : null,
        ]);

        // Add system message
        Message::create([
            'support_ticket_id' => $this->ticketId,
            'sender_id' => Auth::id(),
            'message' => "Ticket status updated to: " . ucfirst($status),
            'message_type' => 'system',
            'is_read' => false,
        ]);

        $this->loadTicket();
        $this->loadMessages();
        
        session()->flash('message', 'Ticket status updated successfully!');
    }

    public function assignTicket($userId = null)
    {
        $this->ticket->update(['assigned_to' => $userId]);

        $assignedUser = $userId ? User::find($userId) : null;
        $message = $userId 
            ? "Ticket assigned to: " . $assignedUser->name
            : "Ticket unassigned";

        // Add system message
        Message::create([
            'support_ticket_id' => $this->ticketId,
            'sender_id' => Auth::id(),
            'message' => $message,
            'message_type' => 'system',
            'is_read' => false,
        ]);

        $this->loadTicket();
        $this->loadMessages();
        
        session()->flash('message', 'Ticket assignment updated successfully!');
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

    public function render()
    {
        $availableUsers = User::whereIn('user_type', ['super_admin', 'admin'])
            ->orderBy('name')
            ->get();

        return view('livewire.super-admin.tickets.ticket-chat-component', [
            'availableUsers' => $availableUsers,
        ]);
    }
}
