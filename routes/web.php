<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

Route::view('/', 'home');

Route::view('/home', 'home')->name('home');
Route::get('/plans', [UserController::class, 'plans_index'])->name('plans.index');
Route::view('/subscriptions/show', 'subscriptions.show')->name('subscriptions.show');
Route::get('/subscriptions/cancel', [SubscriptionController::class, 'cancel'])->name('subscriptions.cancel');

Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login-process',  [AuthController::class, 'loginUser'])->name('login-process');
    Route::post('/register-process',  [AuthController::class, 'registerUser'])->name('register-process');
    Route::view('/register', 'auth.register')->name('register');
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/change-plan', [SubscriptionController::class, 'changeUserPlan'])->name('change-plan');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/files/upload', [DashboardController::class, 'index'])->name('files.upload');
});

Route::middleware('admin')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/plans', [AdminController::class, 'plans_index'])->name('admin.plans.index');
    Route::get('/admin/actions', [AdminController::class, 'actions'])->name('admin.plans.actions');
    Route::post('/admin/plans', [AdminController::class, 'store'])->name('admin.plans.store');
    Route::get('/admin/plans/{plan}/edit', [AdminController::class, 'edit'])->name('admin.plans.edit');
    Route::put('/admin/plans/{plan}', [AdminController::class, 'update'])->name('admin.plans.update');
    Route::delete('/admin/plans/{plan}/destroy', [AdminController::class, 'destroy'])->name('admin.plans.destroy');
    Route::get('/admin/subscriptions', [AdminController::class, 'indexOfSubscriptions'])->name('admin.subscriptions.index');
    Route::get('/admin/subscriptions/{subscriptionId}/show', [SubscriptionController::class, 'showSubscription'])->name('admin.subscriptions.show');
    Route::post('/admin/subscriptions/{subscriptionId}/cancel', [SubscriptionController::class, 'cancelSubscription'])->name('admin.subscriptions.cancel');
    Route::post('/admin/subscriptions/{subscriptionId}/update', [SubscriptionController::class, 'updateSubscription'])->name('admin.subscriptions.update');
    
    Route::get('/admin/users', [AdminController::class, 'indexOfUsers'])->name('admin.users.index');
    
});