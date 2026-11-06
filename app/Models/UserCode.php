<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCode extends Model
{
    protected $fillable = ['form_id', 'code'];
    
    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id', 'id');
    }
}
