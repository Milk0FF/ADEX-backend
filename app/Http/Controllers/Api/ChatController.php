<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Chat\CreateAndUpdateMessageRequest;
use App\Http\Requests\Api\Chat\CreateChatRequest;
use App\Http\Resources\ChatResource;
use App\Http\Resources\MessageResource;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Task;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    //Создание чата и добавление отклика пользователя
    public function createChat(CreateChatRequest $request)
    {
        $user = $request->user();
        if($user->user_type_id !== 1)
            return $this->error('Unautorized', 403);

        $data = $request->validated();
        $chat = Chat::create(['customer_id' => $data['customer_id'], 'executor_id' => $user->id, 'task_id' => $data['task_id']]);

        Message::create(['text' => $data['text'], 'author_id' => $user->id, 'chat_id' => $chat->id]);

        return $this->success('', 204);
    }
    //Добавление сообщения в чат пользователя
    public function createMessage(CreateAndUpdateMessageRequest $request, int $chatId)
    {
        $user = $request->user();
        $chat = Chat::find($chatId);
        if(!$chat)
            return $this->error('Chat not found', 404);

        if($user->id !== $chat->customer_id || $user->id !== $chat->executor_id)
            return $this->error('Unautorized', 403);

        $data = $request->validated();
        $message = Message::create(['text' => $data['text'], 'author_id' => $user->id, 'chat_id' => $chatId]);

        return $this->success(new MessageResource($message));
    }

    //Изменение сообщения из чата пользователя
    public function updateMessage(CreateAndUpdateMessageRequest $request, int $chatId, int $messageId)
    {
        $chat = Chat::find($chatId);
        if(!$chat)
            return $this->error('Chat not found', 404);

        $message = Message::find($messageId);
        if(!$message)
            return $this->error('Message not found', 404);

        $user = $request->user();
        if($message->author_id !== $user->id)
            return $this->error('Unautorized', 403);

        $data = $request->validated();
        $message->update($data);

        return $this->success('', 204);
    }

    //Удаление сообщения из чата пользователя
    public function deleteMessage(Request $request, int $chatId, int $messageId)
    {
        $chat = Chat::find($chatId);
        if(!$chat)
            return $this->error('Chat not found', 404);

        $message = Message::find($messageId);
        if(!$message)
            return $this->error('Message not found', 404);

        $user = $request->user();
        if($message->author_id !== $user->id)
            return $this->error('Unautorized', 403);

        $message->delete();

        return $this->success('', 204);
    }

    //Получение сообщений чата
    public function getChatMessages(Request $request, int $chatId)
    {
        $chat = Chat::find($chatId);
        if(!$chat)
            return $this->error('Chat not found', 404);

        $user = $request->user();
        if($user->id !== $chat->customer_id || $user->id !== $chat->executor_id)
            return $this->error('Unautorized', 403);

        $messages = Message::where('chat_id', $chatId)->get()->all();

        return $this->success(MessageResource::collection($messages));
    }

    //Получение чатов по задаче
    public function getChatsByTask(Request $request, int $taskId)
    {
        $task = Task::find($taskId);
        if(!$task)
            return $this->error('Task not found', 404);
        $user = $request->user();
        if($user->user_type_id !== 2 || $task->customer_id !== $user->id)
            return $this->error('Unautorized', 403);

        return $this->success(ChatResource::collection($task->chats));
    }

    //Получение чатов исполнителя
    public function getChats(Request $request)
    {
        $user = $request->user();
        if($user->user_type_id !== 1)
            return $this->error('Unautorized', 403);

        return $this->success(ChatResource::collection($user->executorChats));
    }
}
