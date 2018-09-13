<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Services\MessageService;
use Illuminate\Http\Request;
use App\Events\MessageCreated;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    protected $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function index($id)
    {
        $messages = $this->messageService->getMessages($id);

        return response()->json($messages);
    }

    public function store(Request $request)
    {
        $message = Message::create([
            'conversation_id' => 1,
            'user_id' => Auth::user()->id,
            'body' => $request->body,
            'type' => $request->type,
        ]);

        broadcast(new MessageCreated($message))->toOthers();

        return response()->json($message);
    }
}
