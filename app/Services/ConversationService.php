<?php

namespace App\Services;

use App\Http\Resources\ConversationResource;
use App\Models\Conversation;
use App\Models\ConversationUser;
use Illuminate\Support\Facades\Auth;

class ConversationService
{
    protected $conversation;

    public function __construct(Conversation $conversation)
    {
        $this->conversation = $conversation;
    }

    public function getConversationsList()
    {
        $conversations = $this->conversation->join('conversations_users',
            function ($join) {
                $join->on('conversations_users.conversation_id', '=', 'conversations.id')
                    ->where('conversations.created_at', '<>', 'conversations.updated_at');
            })
            ->with('last_message.user')
            ->orderBy('conversations.updated_at', 'DESC')
            ->get();

        return new ConversationResource($conversations);
    }

    public function getParticipants($conversation_id)
    {
        return Conversation::where('id', $conversation_id)->with('users')->get();
    }

    public function getMessages($conversation_id)
    {
        return Conversation::where('id', $conversation_id)->with('messages')->get();
    }

    public function findOrCreateWith($user)
    {
        $userId = is_object($user) ? $user->id : $user;

        $loginUserListConversation = ConversationUser::where('user_id', Auth::user()->id)->pluck('conversation_id')->toArray();
        $userListConversation = ConversationUser::where('user_id', $userId)->pluck('conversation_id')->toArray();

        $merge = collect(array_intersect($loginUserListConversation, $userListConversation));

        return $merge->isEmpty() ? $this->createBetween(Auth::user()->id, $userId) : $merge->first();
    }

    public function createBetween($userId, $otherId)
    {
        $create = Conversation::create();
        $create->users()->sync([$userId, $otherId]);

        return $create->id;
    }
}
