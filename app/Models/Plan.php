<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'price',
        'description',
        'features',
        'sort_order',
        'storage_limit',
        'project_limit',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
    public function storageLimit(): string
    {
        return $this->storage_limit ?? '100 MB';
    }
    public function projectLimit(): int
    {
        return (int) ($this->project_limit ?? 1);
    }
    public function isDefault(): bool
    {
        return $this->slug === 'free';
    }
}