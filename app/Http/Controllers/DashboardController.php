<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use App\Models\File as FileModel;
use Illuminate\Support\Facades\Storage;

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
        $user = auth()->user();
        $subscription = $user->subscription;

        $userFiles = $user->files()->get();

        foreach ($userFiles as $fileRecord) {
            if (!Storage::disk('local')->exists($fileRecord->path)) {
                $fileRecord->delete();
            }
        }

        $usedStorage = $user->storageUsedValue();
        $maxStorageLimit = $subscription?->plan?->storage_limit ?? 0;

        $usedProject = $user->projects()->count();
        $maxProjectLimit = $subscription?->plan?->project_limit ?? 0;

        $projects = $user->projects()->withCount('files')->latest()->get();
        $files = $user->files()->latest()->get();
        $recentFiles = $files->take(10);

        return view('dashboard.index', compact(
            'subscription',
            'usedStorage',
            'maxStorageLimit',
            'usedProject',
            'maxProjectLimit',
            'projects',
            'recentFiles',
            'files'
        ));
    }

    public function getMostPopularPlan()
    {
        return Plan::where('is_default', 0)
            ->withCount('subscriptions')
            ->orderByDesc('subscriptions_count')
            ->first();
    }
}