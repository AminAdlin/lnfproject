<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'claim_id',
        'user_id',
        'amount',
        'payment_status',
        'payment_reference',
    ];

    public function claim()
    {
        return $this->belongsTo(Claim::class);
    }
}