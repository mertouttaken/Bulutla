<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\Plan;
use App\Http\Requests\PlanRequest;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        $totalSubscription = Subscription::count();
        $totalValue = Subscription::join('plans', 'subscriptions.plan_id', '=', 'plans.id')
            ->sum('plans.price');
        $maxStorageLimit = $this->maxStorageLimit();
        $usedStorage = $this->usedStorage();
        $getMostPopularPlan = $this->getMostPopularPlan();
        return view('admin.index', compact('totalSubscription', 'totalValue', 'maxStorageLimit', 'usedStorage', 'getMostPopularPlan'));
    }
    public function plans_index()
    {
        $plans = Plan::orderBy('sort_order', 'asc')->get();
        return view('admin.plans.index', compact('plans'));
    }
    public function indexOfUsers()
    {
        $users = User::with('subscription.plan')->get();
        $plans = Plan::orderBy('sort_order', 'asc')->get();
        return view('admin.users.index', compact('users', 'plans'));
    }
    public function actions()
    {
        $plans = Plan::orderBy('sort_order', 'asc')->get();
        return view('admin.plans.actions', compact('plans'));
    }
    public function indexOfSubscriptions()
    {
        $subscriptions = Subscription::with('user', 'plan')->get();
        return view('admin.subscriptions.index', compact('subscriptions'));
    }
    public function store(PlanRequest $request)
    {
        Plan::create($request->only('name', 'slug', 'storage_limit', 'project_limit', 'price', 'description', 'features', 'sort_order'));

        return redirect()->route('admin.plans.index');
    }
    public function edit(Plan $plan)
    {
        return view('admin.plans.edit', compact('plan'));
    }
    public function update(PlanRequest $request, Plan $plan)
    {
        $plan->update($request->only('name', 'slug', 'storage_limit', 'project_limit', 'price', 'description', 'features', 'sort_order'));

        return redirect()->route('admin.plans.actions');
    }
    public function destroy(Plan $plan)
    {
        $plan->delete();

        return redirect()->route('admin.plans.actions');
    }
    public function patchID($currentID, $targetID)
    {
        Plan::where('id', $currentID)->update([
            'id' => $targetID,
        ]);
        Plan::where('id', $targetID)->update([
            'id' => $currentID,
        ]);
    }
    public function getMostPopularPlan()
    {
        return Plan::withCount('subscriptions')
            ->orderByDesc('subscriptions_count')
            ->first();
    }
    public function maxStorageLimit()
    {
        $maxStorageLimit = 1230;
        return $maxStorageLimit;
    }
    public function usedStorage()
    {
        $usedStorage = 320;
        return $usedStorage;
    }
}
