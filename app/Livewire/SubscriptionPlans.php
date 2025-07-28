<?php

namespace App\Livewire;

use App\Helpers\Subscription;
use Livewire\Component;

class SubscriptionPlans extends Component
{
    public $subscriptions;

    public function mount() {
        $this->subscriptions = Subscription::getSubscriptions();
    }

    public function render()
    {
        return view('livewire.subscription-plans');
    }
}
