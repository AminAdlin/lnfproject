<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction;

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
        'bank_qr',           
        'shipping_address',
        'bill_code',
        'transaction_id',
        'payment_method',
        'payment_status',
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

    public function transaction()
{
    return $this->hasOne(Transaction::class, 'claim_id');
}
}