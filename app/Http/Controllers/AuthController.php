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
        $user = User::where('email', request('email'))->first();

        if($user && password_verify(request('password'), $user->password)) {
            Auth::login($user);
            return redirect('home');
        } else {
            return redirect()->back()->withErrors(['email' => 'Invalid credentials']);
        }
    }
    public function registerUser(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),  
        ]);

        $freePlan = Plan::where('slug', 'free')->first();

        Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $freePlan ? $freePlan->id : 1,
            'status' => 'active',
            'ends_at' => null,
        ]);

        Auth::login($user);

        return redirect('home');
    }
    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::logout();
        }

        return redirect('/');
    }
}
