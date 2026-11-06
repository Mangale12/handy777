<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailCount extends Model
{
    use HasFactory;
    protected $table = "email_count";
    protected $fillable = [
        'form_id',
    ];
}
