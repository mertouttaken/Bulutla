<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Subscription;
use App\Models\Plan;
use App\Models\Project;
use App\Models\File;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'is_admin',
        'stripe_id',
        'pm_type',
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

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }
    public function totalStorageBytes()
    {
        return $this->files()->sum('size');
    }

    public function storageUsedValue(): float
    {
        return round($this->totalStorageBytes() / 1048576, 2);
    }

    public function projectUsedValue(): int
    {
        return $this->projects()->count();
    }

    public function storageUsedFormatted(): string
    {
        $bytes = $this->totalStorageBytes();
        $mb = $bytes / 1048576;

        if ($mb >= 1024) {
            return number_format($mb / 1024, 2, ',', '.') . ' GB';
        }

        return number_format($mb, 1, ',', '.') . ' MB';
    }

    public function projectUsed(): string
    {
        return $this->projectUsedValue() . ' Project';
    }
}