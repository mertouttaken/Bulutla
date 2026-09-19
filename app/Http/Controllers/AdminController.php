<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Plan;
use App\Models\File as FileModel;
use App\Http\Requests\PlanRequest;
use App\Models\File;
class AdminController extends Controller
{
    public function index()
    {
        $totalSubscription = Subscription::where('status', 'active')->count();

        $totalValue = Subscription::where('subscriptions.status', 'active')
            ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
            ->sum('plans.price');

        $maxStorageLimit = $this->maxServerStorageLimit();
        $usedStorage = $this->usedServerStorage();
        $getMostPopularPlan = Plan::getMostPopularPlan();
        $subscriptions = Subscription::with('user', 'plan')->latest()->get();

        return view('admin.index', compact(
            'totalSubscription', 
            'totalValue', 
            'maxStorageLimit', 
            'usedStorage', 
            'getMostPopularPlan', 
            'subscriptions'
        ));
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
        $plans = Plan::orderBy('sort_order', 'asc')->get();
        return view('admin.subscriptions.index', compact('subscriptions', 'plans'));
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

    public function maxServerStorageLimit()
    {
        return round(disk_total_space(storage_path()) / 1024 / 1024 / 1024, 2);
    }

    public function usedServerStorage()
    {
        return round(FileModel::sum('size') / 1024 / 1024 / 1024, 2);
    }

    public function userEdit(User $user)
    {
        $plans = Plan::orderBy('sort_order', 'asc')->get();
        return view('admin.users.edit', compact('user', 'plans'));
    }

    public function userUpdate(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'plan_id'  => 'required|exists:plans,id',
            'is_admin' => 'required|boolean',
        ]);

        $userData = $request->only('name', 'email');

        if ($request->filled('password')) {
            $userData['password'] = bcrypt($request->password);
        }
        $userData['is_admin'] = (bool) $request->input('is_admin', 0);
        $user->update($userData);

        $user->subscriptions()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'plan_id' => $request->plan_id,
                'status'  => 'active',
                'ends_at' => now()->addMonth(),
            ]
        );

        return redirect()->route('admin.users.index')->with('success', 'Kullanıcı başarıyla güncellendi.');
    }
    public function userDestroy(User $user)
    {
        File::destroyData($user);

        $user->delete();

        $user->files()->delete();

        return redirect()->route('admin.users.index')->with('success', 'Kullanıcı başarıyla silindi.');
    }
}