<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;

class UserController extends Controller
{
    public function index()
    {
        return view('home');
    }
    public function plans_index()
    {
        $plans = Plan::orderBy('sort_order', 'asc')->get();
        return view('plans.index', compact('plans'));
    }
}
