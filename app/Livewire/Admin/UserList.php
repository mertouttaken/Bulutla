<?php

namespace App\Livewire\Admin;

use App\Models\Plan;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Kullanıcı Yönetimi')]
class UserList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $roleFilter = '';
    public string $planFilter = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    public function updatingPlanFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::with(['subscription.plan'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->roleFilter !== '', function ($query) {
                if ($this->roleFilter === 'admin') {
                    $query->where('is_admin', 1);
                } elseif ($this->roleFilter === 'user') {
                    $query->where('is_admin', 0);
                }
            })
            ->when($this->planFilter !== '', function ($query) {
                $query->whereHas('subscription.plan', function ($q) {
                    $q->where('slug', $this->planFilter);
                });
            })
            ->latest()
            ->paginate(15);

        return view('livewire.admin.user-list', [
            'users' => $users,
            'plans' => Plan::all(),
        ]);
    }
}