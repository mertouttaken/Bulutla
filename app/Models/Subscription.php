<?php

namespace App\Models;

use App\Models\User;
use App\Models\Plan;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'subscriptions';

    protected $fillable = [
        'user_id',
        'plan_id',
        'status',
        'ends_at',
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
}
