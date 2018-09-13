<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageNotification extends Model
{
    use SoftDeletes;

    protected $table = 'notification_messages';

    protected $fillable = ['user_id', 'message_id', 'conversation_id'];

    protected $dates = ['deleted_at'];
}
