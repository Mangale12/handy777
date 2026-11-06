<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NetWork extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 
        'symbol', 
        'icon', 
        'has_multiple_coins', 
        'default_address', 
        'logo', 
        'description', 
        'badge',
        'status', 
        'qr',
    ];

    public function wallets()
    {
        return $this->hasMany(CoinsAddress::class, 'net_work_id', 'id');
    }
}
