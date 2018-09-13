<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversation extends Model
{
    use SoftDeletes;

    protected $table = 'conversations';

    protected $fillable = ['name'];

    /**
     * Relationships in Conversation model
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'conversations_users', 'conversation_id', 'user_id')->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'conversation_id', 'id');
    }

    public function last_message()
    {
        return $this->hasOne(Message::class)->orderBy('messages.id', 'desc');
    }
}
