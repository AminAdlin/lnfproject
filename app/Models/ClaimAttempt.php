<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClaimAttempt extends Model
{
    protected $fillable = ['item_id', 'user_id', 'attempts', 'locked'];
}