<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Form;
use App\Models\FormGame;
use App\Models\Account;

class CashApp extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [

        'title', 'balance','status','deleted_at','updated_at'

    ];
}
