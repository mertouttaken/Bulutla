<?php

namespace App\Livewire\Admin;

use App\Models\Plan;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Mevcut Plan Listesi')]
class PlanList extends Component
{
    public function render()
    {
        $plans = Plan::withCount(['subscriptions' => fn($q) => $q->where('status', 'active')])
            ->orderBy('sort_order')
            ->get();

        return view('livewire.admin.plan-list', [
            'plans' => $plans,
        ]);
    }
}