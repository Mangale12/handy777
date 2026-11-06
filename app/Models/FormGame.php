<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Account;
use App\Models\Form;
use App\Models\FormBalance;

class FormGame extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'form_games';

    protected $fillable = [

        'form_id', 'account_id','game_id','deleted_at','updated_at','created_by'

    ];

    public function form(){
        return $this->hasOne(Form::class,'id','form_id');
    }

    public function formBalance(){
        return $this->hasMany(FormBalance::class,'account_id','id')->with('form')->orderBy('id','desc');
    }
    public function account(){
        return $this->hasOne(Account::class,'id','account_id');
    }

    public function scopeKeywordSearch($query, $searchTerm)
    {
        return $query
        ->where('game_id', 'LIKE', "%" . $searchTerm . "%")
        ->orWhereHas('form', function ($q) use($searchTerm) {
            $q->where('facebook_name', 'like', '%' . $searchTerm . '%');
        });
    }

}
