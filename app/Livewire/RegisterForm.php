<?php

namespace App\Livewire;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Bulutla | Kayıt Ol')]
class RegisterForm extends Component
{
    #[Validate('required|string|min:3', message: [
        'required' => 'Lütfen adınızı girin.',
        'min' => 'Adınız en az 3 karakter olmalıdır.',
    ])]
    public string $name = '';

    #[Validate('required|email|unique:users,email', message: [
        'required' => 'Lütfen e-posta adresinizi girin.',
        'email' => 'Geçerli bir e-posta adresi girin.',
        'unique' => 'Bu e-posta adresi zaten kullanımda.',
    ])]
    public string $email = '';

    #[Validate('required|min:6', message: [
        'required' => 'Lütfen parolanızı girin.',
        'min' => 'Parolanız en az 6 karakter olmalıdır.',
    ])]
    public string $password = '';

    public function submit()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ]);

        $defaultPlan = Plan::where('is_default', 1)->first();

        Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $defaultPlan ? $defaultPlan->id : 1,
            'status' => 'active',
            'ends_at' => now()->addMonth(),
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.register-form')->layout('layouts.app');
    }
}