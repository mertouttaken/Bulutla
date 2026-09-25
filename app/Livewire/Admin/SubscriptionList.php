<?php

namespace App\Livewire\Admin;

use App\Models\Plan;
use App\Models\Subscription;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Abonelik Yönetimi')]
class SubscriptionList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $planFilter = '';
    public string $statusFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPlanFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function cancelSubscription(int $subscriptionId)
    {
        $subscription = Subscription::find($subscriptionId);

        if ($subscription && $subscription->status === 'active') {
            $subscription->update([
                'status'  => 'cancelled',
                'ends_at' => now(),
            ]);

            session()->flash('success', 'Abonelik başarıyla iptal edildi.');
        }
    }

    public function render()
    {
        $plans = Plan::where('price', '>', 0)->get();

        $subscriptions = Subscription::with(['user', 'plan'])
            ->whereHas('plan', fn($q) => $q->where('price', '>', 0))
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->planFilter, function ($query) {
                $query->whereHas('plan', fn($q) => $q->where('slug', $this->planFilter));
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->latest()
            ->paginate(15);

        return view('livewire.admin.subscription-list', compact('plans', 'subscriptions'));
    }
}