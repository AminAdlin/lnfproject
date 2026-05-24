<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'location',
        'date_reported',
        'contact',
        'image',
        'type',
        'status',
        'security_question',
        'security_answer',
        'bank_name', 
        'bank_account', 
        'bank_qr'
    ];
    
    protected $casts = [
    'status' => 'string',
    'date_reported' => 'date',
];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function claims()
    {
        return $this->hasMany(Claim::class);
    }
}