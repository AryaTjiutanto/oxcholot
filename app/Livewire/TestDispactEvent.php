<?php

namespace App\Livewire;

use Livewire\Component;

class TestDispactEvent extends Component
{
    public function render()
    {
        return view('livewire.test-dispact-event');
    }

    public function sendEvent($type,$message) {
        $this->dispatch('event-changed', type: $type, message:$message);
    }
}
