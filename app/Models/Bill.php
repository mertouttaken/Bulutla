<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = 'bill';

    protected $fillable = [
        'user_id',
        'plan_id',
        'amount',
        'status',
        'payment_method',
        'transaction_id',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function amount() { return $this->amount; }
    public function status() { return $this->status; }
    public function paymentMethod() { return $this->payment_method; }
    public function transactionId() { return $this->transaction_id; }
    public function paidAt() { return $this->paid_at; }
}