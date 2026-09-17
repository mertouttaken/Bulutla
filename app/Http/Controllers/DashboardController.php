<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $mostPopularPlan = $this->getMostPopularPlan();
        $plans = Plan::orderBy('sort_order', 'asc')->get();
        return view('home', compact('mostPopularPlan', 'plans'));
    }
    public function indexofDashboard()
    {
        $subscription = auth()->user()->subscription;
        $usedStorage = auth()->user()->storageUsedValue();
        $maxStorageLimit = auth()->user()->subscription->plan->storage_limit;
        $usedProject = auth()->user()->projectUsedValue();
        $maxProjectLimit = auth()->user()->subscription->plan->project_limit;
        return view('dashboard.index', compact('subscription', 'usedStorage', 'maxStorageLimit', 'usedProject', 'maxProjectLimit'));
    }
    public function getMostPopularPlan()
    {
        return Plan::withCount('subscriptions')
            ->orderByDesc('subscriptions_count')
            ->first();
    }
}
