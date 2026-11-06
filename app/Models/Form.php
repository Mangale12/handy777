<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\FormTip;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Form extends Authenticatable implements JWTSubject
{
    protected $table = 'forms';
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [

        'full_name', 'number','email','intervals','mail','count','note','r_id','game_id','facebook_name','token','status_id','balance','redeem_status','ip','device_id','user_id'

    ];

    public function tips(){
        return $this->hasMany(FormTip::class,'form_id','id');
    }
    public function activityStatus(){
        return $this->belongsTo(ActivityStatus::class, 'status_id');
    }
    public function unsubmail(){
        return $this->hasMany(Unsubmail::class, 'form_id','id')->orderBy('id','desc');
    }

    public function getLoadSum()
    {
        return $this->hasMany(History::class, 'form_id')
                    ->where('type', 'load')
                    ->groupBy('account_id')
                    ->sum('amount_loaded');
    }

    // public function getLoadSum()
    // {
    //     return $this->hasMany(History::class, 'form_id')
    //                 ->where('type', 'load')
    //                 ->selectRaw('account_id, SUM(amount_loaded) as total_loaded')
    //                 ->groupBy('account_id');
    // }


    public function getRedeemSum()
    {
        return $this->hasMany(History::class, 'form_id')
                    ->where('type', 'redeem')
                    ->sum('amount_loaded');
    }

    public function getTipsSum()
    {
        return $this->hasMany(History::class, 'form_id')
                    ->where('type', 'tip')
                    ->sum('amount_loaded');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function historyLast7Days()
    {
        return $this->hasMany(History::class, 'form_id')
            ->where('created_at', '>=', now()->subDays(7))
            ->where('created_at', '<=', now());
    }

    public function loadSumLast7Days()
    {
        return $this->hasMany(History::class, 'form_id')
            ->where('type', 'load')
            ->where('created_at', '>=', now()->subDays(7))
            ->selectRaw('form_id, SUM(amount_loaded) as sum')
            ->groupBy('form_id');
    }

    public function redeemSumLast7Days()
    {
        return $this->hasMany(History::class, 'form_id')
            ->where('type', 'redeem')
            ->where('created_at', '>=', now()->subDays(7))
            ->selectRaw('form_id, SUM(amount_loaded) as sum')
            ->groupBy('form_id');
    }

    public function tipsSumLast7Days()
    {
        return $this->hasMany(History::class, 'form_id')
            ->where('type', 'tip')
            ->where('created_at', '>=', now()->subDays(7))
            ->selectRaw('form_id, SUM(amount_loaded) as sum')
            ->groupBy('form_id');
    }

     public function histories(){
        return $this->hasMany(History::class, 'form_id');
    }

    public function latestCode()
    {
        return $this->hasOne(UserCode::class, 'form_id', 'id')->latestOfMany();
    }

}
