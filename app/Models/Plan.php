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
        'is_default',
    ];
    protected $casts = [
        'is_default' => 'boolean',
    ];
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
    public function storageLimit(): int
    {
        if($storageLimit = $this->storage_limit) {
            if (stripos($storageLimit, 'MB') !== false) {
                return (int) filter_var($storageLimit, FILTER_SANITIZE_NUMBER_INT);
            } elseif (stripos($storageLimit, 'GB') !== false) {
                return (int) filter_var($storageLimit, FILTER_SANITIZE_NUMBER_INT) * 1024;
            }
        }
        return 0;
    }
    public function projectLimit(): int
    {
        return (int) ($this->project_limit ?? 1);
    }
    public function isDefault(): bool
    {
        return (bool) $this->is_default;
    }
    public static function getMostPopularPlan()
    {
        return Plan::where('is_default', 0)
            ->withCount('subscriptions')
            ->orderByDesc('subscriptions_count')
            ->first();
    }
}