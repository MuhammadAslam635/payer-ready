<?php

namespace App\Livewire\Doctor\SupportsTickets;

use App\Models\SupportTicket;
use App\Models\Message;
use App\Models\Chat;
use App\Traits\HasToast;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Title("Chat")]
#[Layout('layouts.dashboard')]
class ChatSupportTicketComponent extends Component
{
    use HasToast;
    use WithFileUploads;

    public $supportTicketId;
    public $supportTicket;
    public $chat;
    public $messages = [];
    public $newMessage = '';
    public $attachments = [];
    public $isTyping = false;
    public $lastMessageId = null;

    protected $listeners = [
        'messageReceived' => 'loadNewMessages',
        'echo:support-chat.{supportTicketId},MessageSent' => 'messageReceived',
    ];

    protected $rules = [
        'newMessage' => 'required|string|max:2000',
        'attachments.*' => 'file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx,txt',
    ];

    public function mount($supportTicketId)
    {
        // dd($supportTicketId);
        $this->supportTicketId = $supportTicketId;
        $this->loadSupportTicket();
        $this->loadMessages();
    }

    public function loadSupportTicket()
    {
        $this->supportTicket = SupportTicket::with('user')
            ->where('id', $this->supportTicketId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Get or create chat for this support ticket
        $this->chat = Chat::firstOrCreate([
            'support_ticket_id' => $this->supportTicketId,
        ], [
            'name' => 'Support Ticket #' . $this->supportTicket->ticket_number,
            'type' => 'support',
            'created_by' => Auth::id(),
            'is_active' => true,
        ]);
    }

    public function loadMessages()
    {
        $this->messages = Message::with(['sender'])
            ->where('support_ticket_id', $this->supportTicketId)
            ->orderBy('created_at', 'asc')
            ->get()
            ->toArray();

        if (!empty($this->messages)) {
            $this->lastMessageId = end($this->messages)['id'];
        }

        // Mark messages as read
        Message::where('support_ticket_id', $this->supportTicketId)
            ->where('sender_id', '!=', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now(), 'is_read' => true]);

        $this->dispatch('scrollToBottom');
    }

    public function loadNewMessages()
    {
        $newMessages = Message::with(['sender'])
            ->where('support_ticket_id', $this->supportTicketId)
            ->where('id', '>', $this->lastMessageId ?? 0)
            ->orderBy('created_at', 'asc')
            ->get();

        if ($newMessages->count() > 0) {
            foreach ($newMessages as $message) {
                $this->messages[] = $message->toArray();
            }
            $this->lastMessageId = $newMessages->last()->id;
            
            // Mark new messages as read
            Message::where('support_ticket_id', $this->supportTicketId)
                ->where('sender_id', '!=', Auth::id())
                ->whereNull('read_at')
                ->update(['read_at' => now(), 'is_read' => true]);

            $this->dispatch('scrollToBottom');
        }
    }

    public function sendMessage()
    {
        $this->validate();

        $attachmentPaths = [];
        if (!empty($this->attachments)) {
            foreach ($this->attachments as $attachment) {
                $path = $attachment->store('assets/support-attachments', 'public');
                $attachmentPaths[] = [
                    'name' => $attachment->getClientOriginalName(),
                    'path' => $path,
                    'size' => $attachment->getSize(),
                    'type' => $attachment->getMimeType(),
                ];
            }
        }

        $message = Message::create([
            'chat_id' => $this->chat->id,
            'support_ticket_id' => $this->supportTicketId,
            'sender_id' => Auth::id(),
            'message' => $this->newMessage,
            'message_type' => 'text',
            'attachments' => !empty($attachmentPaths) ? json_encode($attachmentPaths) : null,
            'is_read' => false,
        ]);

        // Update chat last message time
        $this->chat->update([
            'last_message_at' => now(),
        ]);

        // Update support ticket status if it's closed
        if ($this->supportTicket->status === 'closed') {
            $this->supportTicket->update(['status' => 'open']);
        }

        // Broadcast the message
        broadcast(new \App\Events\MessageSent($message))->toOthers();

        // Reset form
        $this->reset(['newMessage', 'attachments']);
        $this->loadMessages();

        $this->toastSuccess('Message sent successfully!');
    }

    public function removeAttachment($index)
    {
        unset($this->attachments[$index]);
        $this->attachments = array_values($this->attachments);
    }

    public function updateTicketStatus($status)
    {
        $this->supportTicket->update(['status' => $status]);
        
        // Add system message
        Message::create([
            'chat_id' => $this->chat->id,
            'support_ticket_id' => $this->supportTicketId,
            'sender_id' => Auth::id(),
            'message' => "Ticket status updated to: " . ucfirst($status),
            'message_type' => 'system',
            'is_read' => false,
        ]);

        $this->loadMessages();
        $this->toastSuccess('Ticket status updated successfully!');
    }

    public function startTyping()
    {
        $this->isTyping = true;
        broadcast(new \App\Events\UserTyping($this->supportTicketId, Auth::user()))->toOthers();
    }

    public function stopTyping()
    {
        $this->isTyping = false;
        broadcast(new \App\Events\UserStoppedTyping($this->supportTicketId, Auth::user()))->toOthers();
    }

    public function getStatusColorProperty()
    {
        return match($this->supportTicket->status) {
            'open' => 'bg-green-100 text-green-800',
            'in_progress' => 'bg-blue-100 text-blue-800',
            'pending' => 'bg-yellow-100 text-yellow-800',
            'resolved' => 'bg-purple-100 text-purple-800',
            'closed' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getPriorityColorProperty()
    {
        return match($this->supportTicket->priority) {
            'urgent' => 'bg-red-100 text-red-800',
            'high' => 'bg-orange-100 text-orange-800',
            'medium' => 'bg-yellow-100 text-yellow-800',
            'low' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
    public function render()
    {
        return view('livewire.doctor.supports-tickets.chat-support-ticket-component');
    }
}
