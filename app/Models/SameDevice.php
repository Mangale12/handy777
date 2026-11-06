<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SameDevice extends Model
{
    use HasFactory;
    protected $fillable = [
        'full_name', 'number','email','intervals','mail','count','note','r_id','game_id','facebook_name','token','status_id','balance','redeem_status','ip','device_id',

    ];
}
