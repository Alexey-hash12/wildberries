<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $timestamps = null;
    public $casts = [
        'user' => 'array',
        'skus' => 'array',
        'offices' => 'array'
    ];
}
