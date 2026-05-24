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
        'payment_receipt'
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