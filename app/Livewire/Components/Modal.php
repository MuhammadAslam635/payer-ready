<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Modal extends Component
{
    public $show = false;
    public $title = '';
    public $size = 'md'; // sm, md, lg, xl, 2xl
    public $closable = true;
    public $persistent = false;

    protected $listeners = [
        'open-modal' => 'open',
        'close-modal' => 'close',
        'toggle-modal' => 'toggle'
    ];

    public function open($title = '', $size = 'md')
    {
        $this->title = $title;
        $this->size = $size;
        $this->show = true;
        $this->dispatch('modal-opened');
    }

    public function close()
    {
        if (!$this->persistent) {
            $this->show = false;
            $this->dispatch('modal-closed');
        }
    }

    public function toggle()
    {
        $this->show = !$this->show;
    }

    public function getSizeClasses()
    {
        return match($this->size) {
            'sm' => 'max-w-sm',
            'md' => 'max-w-md',
            'lg' => 'max-w-lg',
            'xl' => 'max-w-xl',
            '2xl' => 'max-w-2xl',
            '3xl' => 'max-w-3xl',
            '4xl' => 'max-w-4xl',
            '5xl' => 'max-w-5xl',
            '6xl' => 'max-w-6xl',
            '7xl' => 'max-w-7xl',
            default => 'max-w-md'
        };
    }

    public function render()
    {
        return view('livewire.components.modal');
    }
}
