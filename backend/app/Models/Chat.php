<?php

namespace App\Models;

use App\Models\UserChat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    use HasFactory;


    protected $table = 'chats';

    protected $fillable = ['name'];


    function users(): HasMany
    {
        return $this->hasMany(UserChat::class);
    }
    function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
