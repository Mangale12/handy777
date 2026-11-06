<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\FormGame;
use App\Models\FormTip;
use App\Models\FormBalance;


class Account extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [

        'title','name', 'balance','status','deleted_at','updated_at','image','game_url',

    ];

    public function formGames(){
        return $this->hasMany(FormGame::class,'account_id','id')->whereHas('form')->with('form')->orderBy('game_id','asc');
    }

    // public function formBalance(){
    //     return $this->hasMany(FormBalance::class,'account_id','account_id')->get();
    // }
    public function tips(){
        return $this->hasOne(FormTip::class,'form_id','form_id');
        // return $this->hasOne(FormGame::class)->where('account_id', 'account_id');
        // return $this->hasOne(FormGame::class)->where([['account_id', 'account_id'],['form_id','form_id']]);
    }
}
