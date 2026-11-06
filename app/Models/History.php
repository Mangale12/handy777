<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Form;
use App\Models\FormGame;
use App\Models\Account;
use App\Models\User;

class History extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [

        'created_at','form_id','relation_id', 'account_id','cash_apps_id','amount_loaded','previous_balance','final_balance','type','created_by','deleted_at','updated_at'

    ];

    
    public function form(){
        return $this->hasOne(Form::class,'id','form_id');
    }
    public function account(){
        return $this->hasOne(Account::class,'id','account_id');
    }
    public function created_by(){
        return $this->hasOne(User::class,'id','created_by');
    }
    public function formGames(){
        return $this->hasOne(FormGame::class,'form_id','form_id');
        // return $this->hasOne(FormGame::class)->where('account_id', 'account_id');
        // return $this->hasOne(FormGame::class)->where([['account_id', 'account_id'],['form_id','form_id']]);
    }
    
     public function game()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
