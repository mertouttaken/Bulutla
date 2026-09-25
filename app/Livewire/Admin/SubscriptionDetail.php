<?php

namespace App\Livewire\Admin;

use App\Models\Plan;
use App\Models\Subscription;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Abonelik Yönetimi')]
class SubscriptionDetail extends Component
{
    public Subscription $subscription;

    public int $plan_id;
    public string $status;
    public ?string $ends_at = null;

    public function mount(Subscription $subscription)
    {
        $this->subscription = $subscription->load(['user', 'plan']);
        $this->plan_id = $subscription->plan_id;
        $this->status = $subscription->status;
        $this->ends_at = $subscription->ends_at ? Carbon::parse($subscription->ends_at)->format('Y-m-d') : null;
    }

    public function updateSubscription()
    {
        $this->validate([
            'plan_id' => 'required|exists:plans,id',
            'status'  => 'required|in:active,cancelled',
            'ends_at' => 'nullable|date',
        ]);

        $this->subscription->update([
            'plan_id' => $this->plan_id,
            'status'  => $this->status,
            'ends_at' => $this->ends_at,
        ]);

        $this->subscription->refresh();
        session()->flash('success', 'Abonelik bilgileri güncellendi.');
    }

    public function cancelSubscription()
    {
        $this->subscription->update([
            'status'  => 'cancelled',
            'ends_at' => now(),
        ]);

        $this->status = 'cancelled';
        $this->ends_at = now()->format('Y-m-d');
        $this->subscription->refresh();

        session()->flash('success', 'Abonelik başarıyla sonlandırıldı.');
    }

    public function render()
    {
        return view('livewire.admin.subscription-detail', [
            'plans' => Plan::orderBy('sort_order')->get(),
        ]);
    }
}