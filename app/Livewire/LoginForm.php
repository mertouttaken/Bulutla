<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Title('Bulutla | Giriş Yap')]
class LoginForm extends Component
{
    #[Validate('required|email', message: [
        'required' => 'Lütfen e-posta adresinizi girin.',
        'email' => 'Geçerli bir e-posta adresi girin.',
    ])]
    public string $email = '';

    #[Validate('required|min:6', message: [
        'required' => 'Lütfen parolanızı girin.',
        'min' => 'Parolanız en az 6 karakter olmalıdır.',
    ])]
    public string $password = '';

    public bool $remember = false;
    public bool $success = false;

    public function submit()
    {
        $this->validate();

        // At most 5 failed attempts per email + IP per minute.
        $key = 'login:' . Str::lower($this->email) . '|' . request()->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            $this->reset('password');
            $this->addError('email', "Çok fazla deneme yapıldı. Lütfen {$seconds} saniye sonra tekrar deneyin.");
            return;
        }

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::clear($key);
            session()->regenerate();

            return redirect()->intended(route('home'));
        }

        RateLimiter::hit($key, 60);
        $this->reset('password');
        $this->addError('email', 'Girdiğiniz bilgiler kayıtlarımızla eşleşmiyor.');
    }

    public function render()
    {
        return view('livewire.login-form');
    }
}