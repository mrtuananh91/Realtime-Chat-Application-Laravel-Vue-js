<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConversationUser extends Model
{
    use SoftDeletes;

    protected $table = 'conversations_users';

    /**
     * Relationships in ConversationUser model
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id');
    }
}
