<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Form;
use App\Models\FormGame;
use App\Models\Account;

class CashAppForm extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [

        'cash_app_id','account_id', 'amount','form_id','deleted_at','updated_at','created_at'

    ];
}
