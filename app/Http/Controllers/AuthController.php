<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\Plan;
use App\Models\Subscription;

class AuthController extends Controller
{
    public function loginUser(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('home'));
        }

        return redirect()->back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }

    public function registerUser(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),  
        ]);

        $defaultPlan = Plan::where('is_default', 1)->first();

        Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $defaultPlan ? $defaultPlan->id : 1,
            'status' => 'active',
            'ends_at' => now()->addMonth(),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}