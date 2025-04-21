<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserTransaction extends Model
{
    protected $table = 'user_transactions';

    protected $fillable = [
        'user_id',
        'transaction_id',
        'subscription_id',
        'payment_type',
        'amount',
        'is_successful',
    ];
}
