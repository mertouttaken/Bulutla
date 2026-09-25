<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\Plan;
use App\Models\User;
use App\Models\File as FileModel;
use Illuminate\Support\Facades\DB;
class AdminStatService
{
    public function __construct()
    {
        //
    }

    public function getDashboardStats(): array
    {
        return [
            'activeSubscribers' => Subscription::where('status', 'active')->count(),
            'monthlyIncome'     => $this->getTotalSubscriptionValue(),
            'usedStorage'       => $this->usedServerStorage(),
            'totalStorage'      => $this->maxServerStorageLimit(),
            'popularPlan'       => Plan::getMostPopularPlan(),
        ];
    }
    public function usedServerStorage()
    {
        return round(FileModel::sum('size') / 1024 / 1024 / 1024, 2);
    }
    public function maxServerStorageLimit()
    {
        return round(disk_total_space(storage_path()) / 1024 / 1024 / 1024, 2);
    }
    public function getTotalSubscriptionValue()
    {
        return Subscription::where('subscriptions.status', 'active')
            ->join('plans', 'subscriptions.plan_id', '=', 'plans.id')
            ->sum('plans.price');
    }
}