<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ProjectController;

Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/plans', [UserController::class, 'plans_index'])->name('plans.index');

Route::middleware('guest')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login-process',  [AuthController::class, 'loginUser'])->name('login-process');
    Route::post('/register-process',  [AuthController::class, 'registerUser'])->name('register-process');
    Route::view('/register', 'auth.register')->name('register');
});

Route::middleware('auth')->group(function () {
    Route::view('/subscriptions/show', 'subscriptions.show')->name('subscriptions.show');
    Route::get('/subscriptions/cancel', [SubscriptionController::class, 'cancel'])->name('subscriptions.cancel');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::post('/change-plan', [SubscriptionController::class, 'changeUserPlan'])->name('change-plan');
    
    Route::get('/dashboard', [DashboardController::class, 'indexofDashboard'])->name('dashboard');
    
    Route::post('/dashboard/files/upload', [FileController::class, 'upload'])->name('files.upload');
    Route::get('/dashboard/files/download/{fileId}', [FileController::class, 'download'])->name('files.download');
    Route::delete('/dashboard/files/destroy/{fileId}', [FileController::class, 'destroy'])->name('files.destroy');
    
    Route::get('/dashboard/projects', [ProjectController::class, 'index'])->name('projects.show');        
    Route::post('/dashboard/projects/store', [ProjectController::class, 'projectStore'])->name('projects.store');
    Route::get('/dashboard/projects/create', [ProjectController::class, 'createIndex'])->name('projects.create');   
    Route::get('/dashboard/projects/files/{projectId}', [ProjectController::class, 'showFilesIndex'])->name('projects.files');
    Route::put('/dashboard/projects/store/{projectId}', [ProjectController::class, 'projectStore'])->name('projects.store');          
    Route::delete('/dashboard/projects/destroy/{projectId}', [ProjectController::class, 'projectDestroy'])->name('projects.destroy');   


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
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'userEdit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminController::class, 'userUpdate'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'userDestroy'])->name('admin.users.destroy');
});