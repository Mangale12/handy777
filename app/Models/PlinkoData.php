<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlinkoData extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'plinko_data';

    protected $fillable = [
        'form_id', 'bet_amount', 'multiplier_value', 'risk_level', 'rows_selected', 'game_type',
        'win_balance', 'current_balance', 'new_balance', 'token_used'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
