<?php

namespace App\Services;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageService
{
    protected $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function getMessages($conversation_id)
    {
        $messages = Message::where('conversation_id', $conversation_id)
            ->with('user')
            ->get();

        return $messages->map(function ($message) {
            return [
                'author' => Auth::user()->id == $message->user_id ? 'me' : 'them',
                'type' => $message->type,
                'data' => [
                    'text' => $message->body,
                    'user' => $message->user,
                ]
            ];
        });
//        return $messages;
    }
}
