<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Halloin extends Model
{
    use HasFactory;
    protected $fillable = ['full_name', 'email', 'record_key'];
}
