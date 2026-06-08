<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
    protected $fillable = [
        'item_id',
        'claim_id',
        'raised_by',
        'reason',
        'message',
        'status',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function claim()
    {
        return $this->belongsTo(Claim::class);
    }

    public function raiser()
    {
        return $this->belongsTo(User::class, 'raised_by');
    }
}