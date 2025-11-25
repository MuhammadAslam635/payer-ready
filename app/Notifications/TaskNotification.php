<?php

namespace App\Notifications;

use App\Models\DoctorTask;
use App\Models\TaskType;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $doctorTask;
    protected $taskType;
    protected $assignedBy;
    protected $type;

    /**
     * Create a new notification instance.
     */
    public function __construct(DoctorTask $doctorTask, TaskType $taskType, User $assignedBy, string $type = 'assigned')
    {
        $this->doctorTask = $doctorTask;
        $this->taskType = $taskType;
        $this->assignedBy = $assignedBy;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase($notifiable): DatabaseMessage
    {
        return new DatabaseMessage([
            'type' => $this->type,
            'title' => $this->getTitle(),
            'message' => $this->getMessage(),
            'task_id' => $this->doctorTask->id,
            'task_type_id' => $this->taskType->id,
            'task_name' => $this->taskType->name,
            'assigned_by' => $this->assignedBy->name,
            'assigned_by_id' => $this->assignedBy->id,
            'due_date' => $this->doctorTask->due_date?->format('Y-m-d'),
            'priority' => $this->taskType->default_priority,
            'url' => $this->getUrl(),
        ]);
    }

    /**
     * Get the notification title based on type
     */
    protected function getTitle(): string
    {
        return match ($this->type) {
            'assigned' => 'New Task Assigned',
            'updated' => 'Task Updated',
            'completed' => 'Task Completed',
            'overdue' => 'Task Overdue',
            default => 'Task Notification',
        };
    }

    /**
     * Get the notification message based on type
     */
    protected function getMessage(): string
    {
        return match ($this->type) {
            'assigned' => "You have been assigned a new task: {$this->taskType->name}",
            'updated' => "Task '{$this->taskType->name}' has been updated",
            'completed' => "Task '{$this->taskType->name}' has been completed",
            'overdue' => "Task '{$this->taskType->name}' is overdue",
            default => "Task '{$this->taskType->name}' notification",
        };
    }

    /**
     * Get the URL for the notification
     */
    protected function getUrl(): string
    {
        // Adjust URL based on user type
        return route('dashboard'); // You can customize this based on user role
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->getTitle())
            ->line($this->getMessage())
            ->when($this->doctorTask->due_date, function ($mail) {
                return $mail->line('Due Date: ' . $this->doctorTask->due_date->format('F d, Y'));
            })
            ->when($this->taskType->default_priority, function ($mail) {
                return $mail->line('Priority: ' . ucfirst($this->taskType->default_priority));
            })
            ->line('View task: ' . $this->getUrl());
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return $this->toDatabase($notifiable)->data;
    }
}
