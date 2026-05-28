<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    protected $fillable = [
        'item_id',
        'user_id',
        'answer',
        'delivery_method',
        'status',
        'appointment_date',
        'appointment_location',
        'payment_receipt',
        'message',       
        'contact',       
        'proof_image',
        'is_delivery_ready',
        'bank_name',
        'account_number',
        'payment_receipt_image',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    
    protected $casts = [
    'status' => 'string',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}