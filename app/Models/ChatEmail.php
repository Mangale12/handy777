<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatEmail extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'chat_code',
        'display_name',
        'allow_chat',
        'notes',
        'last_chat_at',
    ];

    protected $casts = [
        'allow_chat' => 'boolean',
        'last_chat_at' => 'datetime',
    ];
}
