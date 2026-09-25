<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
use App\Livewire\LoginForm;
use App\Livewire\RegisterForm;
use App\Livewire\Admin\PlanList;
use App\Livewire\Admin\PlanActions;
use App\Livewire\Admin\PlanEditForm;
use App\Livewire\Admin\SubscriptionList;
use App\Livewire\Admin\SubscriptionDetail;
use App\Livewire\Admin\UserList;
use App\Livewire\Admin\UserEditForm;
use App\Livewire\Projects\Index as ProjectList;
use App\Livewire\Projects\CreateForm as ProjectCreateForm;
use App\Livewire\Projects\FileManager as ProjectFileManager;

Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/plans', [UserController::class, 'plans_index'])->name('plans.index');

Route::middleware('guest')->group(function () {
    Route::get('/login', LoginForm::class)->name('login');
    Route::get('/register', RegisterForm::class)->name('register');
});

Route::middleware('auth')->group(function () {
    Route::view('/subscriptions', 'subscriptions.show')->name('subscriptions.show');
    Route::get('/subscriptions/cancel', [SubscriptionController::class, 'cancel'])->name('subscriptions.cancel');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/change-plan', [SubscriptionController::class, 'changeUserPlan'])->name('change-plan');
    
    Route::get('/dashboard', [DashboardController::class, 'indexofDashboard'])->name('dashboard');
    
    Route::post('/dashboard/files/upload', [FileController::class, 'upload'])->name('files.upload');
    Route::get('/dashboard/files/download/{fileId}', [FileController::class, 'download'])->name('files.download');
    Route::delete('/dashboard/files/destroy/{fileId}', [FileController::class, 'destroy'])->name('files.destroy');
    
    // Proje & Dosya Yönetimi (Livewire Full-Page)
    Route::get('/dashboard/projects', ProjectList::class)->name('projects.show');
    Route::get('/dashboard/projects/create', ProjectCreateForm::class)->name('projects.create');
    Route::get('/dashboard/projects/files/{projectId}', ProjectFileManager::class)->name('projects.files');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::view('/admin', 'admin.index')->name('admin.index');

    Route::get('/admin/plans', PlanList::class)->name('admin.plans.index');
    Route::get('/admin/actions', PlanActions::class)->name('admin.plans.actions');
    Route::get('/admin/plans/{plan}/edit', PlanEditForm::class)->name('admin.plans.edit');

    Route::get('/admin/subscriptions', SubscriptionList::class)->name('admin.subscriptions.index');
    Route::get('/admin/subscriptions/{subscription}', SubscriptionDetail::class)->name('admin.subscriptions.show');
    
    Route::get('/admin/users', UserList::class)->name('admin.users.index');
    Route::get('/admin/users/{user}/edit', UserEditForm::class)->name('admin.users.edit');
});