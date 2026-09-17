<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Subscription;
use App\Models\Plan;

class User extends Authenticatable
{
    

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'is_admin',
        'stripe_id',
        'pm_type',
        'used_storage',
        'used_project',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
    public function subscription()
    {
        return $this->hasOne(Subscription::class)->latestOfMany();
    }

    public function currentPlan()
    {
        return $this->subscription?->plan;
    }
    public function plan()
    {
        return $this->hasOneThrough(Plan::class, Subscription::class, 'user_id', 'id', 'id', 'plan_id');
    }
    public function storageUsed(): string
    {
        return $this->used_storage . ' MB';
    }
    public function storageUsedValue(): float
    {
        return (float) $this->used_storage;
    }
    public function projectUsedValue(): float
    {
        return (float) $this->used_storage;
    }
    public function storageUsedFormatted(): string
    {
        if (str_contains($this->storageUsed(), 'GB')) {
            $rawStorageUsed = (float) $this->storageUsed();
            return number_format($rawStorageUsed, 2, ',', '.') . ' GB';
        } else if(floatval($this->storageUsed()) >= 1024) {
            $rawStorageUsed = (float) $this->storageUsed();
            return number_format($rawStorageUsed / 1024, 2, ',', '.') . ' GB';
        } else {
            $rawStorageUsed = (float) $this->storageUsed();
            return number_format($rawStorageUsed, 1, ',', '.') . ' MB';
        }
    }
    public function projectUsed(): string
    {
        return $this->used_project . ' Project';
    }
}
