<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Form;
use App\Models\FormGame;
use App\Models\Account;
use App\Models\User;

class FormBalance extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [

        'form_id','account_id', 'amount','created_by','deleted_at','updated_at','created_at'

    ];

    
    public function form(){
        return $this->hasOne(Form::class,'id','form_id');
    }
    public function created_by(){
        return $this->hasOne(User::class,'id','created_by');
    }
    public function account(){
        return $this->hasOne(Account::class,'id','account_id');
    }
    public function formGames(){
        return $this->hasOne(FormGame::class,'form_id','form_id');
    }
}
