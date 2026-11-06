<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityStatus extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'activity_status';

    protected $fillable = ['status'];
}
