<?php

namespace App\Livewire\Admin;

use App\Models\Subscription;
use Livewire\Attributes\On;
use Livewire\Component;

class RecentSubscriptionsTable extends Component
{
    #[On('subscription-updated')]
    public function render()
    {
        $subscriptions = Subscription::with(['user', 'plan'])
            ->latest()
            ->take(10)
            ->get();
        return view('livewire.admin.recent-subscriptions-table', [
            'subscriptions' => $subscriptions,
        ]);
    }
}