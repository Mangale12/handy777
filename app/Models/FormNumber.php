<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormNumber extends Model
{
    use HasFactory;
    
    protected $table = 'formnumbers';
    
    protected $fillable = [
        'phone_number',
        'us_citizen',
        'cash_app',
        'driving_license',
        'cash_app_score',
        'cash_app_send_limit',
        'state',
        'crime',
        'extra_1',
        'extra_2',
        'nore',
    ];
}
