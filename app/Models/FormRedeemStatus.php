<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormRedeemStatus extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [

        'form_id', 'status_date','status','created_by'

    ];
}
