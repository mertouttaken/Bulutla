<?php

namespace App\Models;

use App\Models\User;
use App\Models\Plan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Prunable;

class Subscription extends Model
{
    use Prunable;

    protected $table = 'subscriptions';

    protected $fillable = [
        'user_id',
        'plan_id',
        'status',
        'ends_at',
    ];
    protected $casts = [
        'ends_at' => 'datetime',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
    public function nextBillingDate()
    {
        return $this->ends_at ? \Carbon\Carbon::parse($this->ends_at)->format('d.m.Y') : 'Süresiz';
    }
    public function prunable(): Builder
    {
        return static::where('status', '!=', 'active')
            ->where('ends_at', '<=', now()->subDays(30));
    }
    public function cancel(): bool
    {
        $this->status = 'canceled';
        $this->ends_at = now();
        $saved = $this->save();

        if ($saved) {
            $defaultPlan = Plan::where('is_default', true)->first();

            if ($defaultPlan) {
                $this->user->update([
                    'plan_id' => $defaultPlan->id,
                ]);
            }
        }

        return $saved;
    }
}
