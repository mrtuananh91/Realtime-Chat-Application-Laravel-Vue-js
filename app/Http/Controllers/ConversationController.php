<?php

namespace App\Http\Controllers;

use App\Services\ConversationService;

class ConversationController extends Controller
{
    protected $conversationService;

    public function __construct(ConversationService $commentService)
    {
        $this->conversationService = $commentService;
    }

    /**
     * Get list Conversations.
     */
    public function getConversationsList(){
        return $this->conversationService->getConversationsList();
    }

    /**
     * Get all participants in the conversation.
     */
    public function getParticipants($conversation_id)
    {
        return $this->conversationService->getParticipants($conversation_id);
    }

    /**
     * Get all messages in the conversation.
     */
    public function getMessages($conversation_id)
    {
        return $this->conversationService->getMessages($conversation_id);
    }

    /**
     * Find a conversation between login user and another, or create it.
     */
    public function startConversation($user)
    {
        return $this->conversationService->findOrCreateWith($user);
    }
}
