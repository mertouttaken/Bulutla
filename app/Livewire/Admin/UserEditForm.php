<?php

namespace App\Livewire\Admin;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Kullanıcı Düzenle')]
class UserEditForm extends Component
{
    public User $user;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public bool $is_admin = false;
    public ?int $plan_id = null;

    public function mount(User $user)
    {
        $this->user = $user->load(['subscription.plan', 'projects', 'files']);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->is_admin = (bool) $user->is_admin;
        $this->plan_id = $user->subscription?->plan_id;
    }

    public function updateUser()
    {
        $this->validate([
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user->id)],
            'password' => 'nullable|string|min:6',
            'is_admin' => 'boolean',
            'plan_id'  => 'nullable|exists:plans,id',
        ]);

        $userData = [
            'name'     => $this->name,
            'email'    => $this->email,
            'is_admin' => $this->is_admin,
        ];

        if (!empty($this->password)) {
            $userData['password'] = Hash::make($this->password);
        }

        $this->user->update($userData);

        if ($this->plan_id) {
            $subscription = $this->user->subscription;
            if ($subscription) {
                $subscription->update(['plan_id' => $this->plan_id]);
            } else {
                $this->user->subscriptions()->create([
                    'plan_id' => $this->plan_id,
                    'status'  => 'active',
                ]);
            }
        }

        $this->password = '';
        $this->user->refresh();

        session()->flash('success', 'Kullanıcı bilgileri başarıyla güncellendi.');
    }

    public function deleteUser()
    {
        if (auth()->id() === $this->user->id) {
            session()->flash('error', 'Kendi hesabınızı silemezsiniz.');
            return;
        }

        $this->user->delete();

        session()->flash('success', 'Kullanıcı başarıyla silindi.');
        return redirect()->route('admin.users.index');
    }

    public function render()
    {
        return view('livewire.admin.user-edit-form', [
            'plans' => Plan::orderBy('sort_order')->get(),
        ]);
    }
}