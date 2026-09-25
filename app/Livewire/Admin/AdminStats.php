<?php

namespace App\Livewire\Admin;

use App\Services\AdminStatService;
use Livewire\Attributes\On;
use Livewire\Component;

class AdminStats extends Component
{
    #[On('subscription-updated')]
    public function render(AdminStatService $statService)
    {
        return view('livewire.admin.admin-stats', $statService->getDashboardStats());
    }
}