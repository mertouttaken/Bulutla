<?php

namespace App\Livewire\Subscriptions;

use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Bill;
#[Layout('layouts.app')]
#[Title('Aboneliğim')]
class Show extends Component
{
    public function render()
    {
        $user = Auth::user();
        $subscription =$user->subscription;
        $plan =$user->plan;

        $storageUsed = (float)$user->storageUsedValue();

        $rawLimit = (string) ($plan?->storageLimit() ?? $plan?->storage_limit ?? '0');
        preg_match('/([\d.]+)\s*([a-zA-Z]*)/', $rawLimit, $matches);$limitVal = isset($matches[1]) ? (float)$matches[1] : 0;
        $limitUnit = isset($matches[2]) ? strtoupper(trim($matches[2])) : 'MB';
        $storageLimit = ($limitUnit === 'GB') ? ($limitVal * 1024) :$limitVal;
        $storagePercent =$storageLimit > 0 ? min(100, round(($storageUsed / $storageLimit) * 100)) : 0;

        $projectUsed = (int) $user->projectUsedValue();$projectLimit = (int) ($plan?->projectLimit() ?? $plan?->project_limit ?? 0);
        $projectPercentage =$projectLimit > 0 ? min(100, round(($projectUsed / $projectLimit) * 100)) : 0;

        $canCancel = $subscription &&$subscription->status === 'active' && !$subscription->plan->isDefault();$defaultPlanName = Plan::where('is_default', 1)->first()?->name ?? 'Default';
        $bills = $user->bills()->with('plan')->latest()->get();

        return view('livewire.subscriptions.show', compact(
            'subscription',
            'plan',
            'storageUsed',
            'storageLimit',
            'storagePercent',
            'projectUsed',
            'projectLimit',
            'projectPercentage',
            'canCancel',
            'defaultPlanName',
            'bills'
        ));
    }
}