<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'delivery_id',
        'amount',
        'method',
        'currency',
        'confirmed',
    ];
    
}
