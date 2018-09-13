<?php

namespace App\Services;

use App\Models\Message;

class MessageService
{
    protected $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function getMessages($conversation_id)
    {
        return Message::where('conversation_id', $conversation_id)
            ->with('user')
            ->get();
    }
}
