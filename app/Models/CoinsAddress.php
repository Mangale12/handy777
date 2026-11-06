<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinsAddress extends Model
{
    use HasFactory;
    protected $fillable = [
            'icon',
            'qr',
            'address',
            'status',
            'net_work_id',
            'wallet',
            'status',
            'badge',
            'description',
        ];
}
