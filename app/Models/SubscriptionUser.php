<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionUser extends Model
{
    protected $fillable = [
        'subscription_plan_id',
        'transaction_id',
        'user_id',
        'is_active',
        'expires_at',
        'is_autorenew',
    ];


    function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    function subscription_plans(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id', 'id');
    }

}
