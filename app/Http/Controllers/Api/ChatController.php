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
    /**
     *
     * @OA\Post(
     *     path="/chat",
     *     operationId="createChat",
     *     tags={"Chat"},
     *     summary="Создание чата исполнителем, когда оставляет отклик",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\RequestBody(
     *        required=true,
     *        description = "Заполните поля для создания чата",
     *        @OA\JsonContent(
     *           required={"customer_id", "task_id", "text"},
     *           @OA\Property(property="сustomer_id", type="int", example="2"),
     *           @OA\Property(property="task_id", type="int", example="2"),
     *           @OA\Property(property="text", type="string", example="Это отклик!"),
     *       ),
     *     ),
     *     @OA\Response(
     *        response=204,
     *        description="Successful operation",
     *        @OA\JsonContent(),
     *      ),
     *     @OA\Response(
     *        response=401,
     *        description="Unauthenticated.",
     *        @OA\JsonContent(
*               @OA\Property(property="message", type="string", example="Unauthenticated"),
     *        ),
     *      ),
     *     @OA\Response(
     *        response=403,
     *        description="Unautorized.",
     *        @OA\JsonContent(
     *           @OA\Property(property="errors", type="object",
     *              @OA\Property(property="message", type="string", example="Unautorized"),
     *           ),
     *        ),
     *      ),
     *
     * )
     */

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

    /**
     *
     * @OA\Post(
     *     path="/chat/{chatId}/message",
     *     operationId="createMessage",
     *     tags={"Chat"},
     *     summary="Добавление сообщения в чат",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\RequestBody(
     *        required=true,
     *        description = "Заполните поля для добавления сообщения в чат",
     *        @OA\JsonContent(
     *           required={"text"},
     *           @OA\Property(property="text", type="string", example="Текст сообщения"),
     *       ),
     *     ),
     *     @OA\Response(
     *        response=200,
     *        description="Successful operation",
     *        @OA\JsonContent(
     *           @OA\Property(property="id", type="int", example="1"),
     *           @OA\Property(property="text", type="string", example="Это текст сообщения!"),
     *           @OA\Property(property="author", type="object",
     *             @OA\Property(property="id", type="int", example="1"),
     *             @OA\Property(property="username", type="string", example="userreg1"),
     *             @OA\Property(property="firstname", type="string", example="Ivan"),
     *             @OA\Property(property="lastname", type="string", example="Ivanovich"),
     *          ),
     *          @OA\Property(property="chat_id", type="int", example="1"),
     *          @OA\Property(property="created_at", type="date", example="2021-04-04"),
     *        ),
     *      ),
     *     @OA\Response(
     *        response=401,
     *        description="Unauthenticated.",
     *        @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Unauthenticated"),
     *        ),
     *      ),
     *     @OA\Response(
     *        response=403,
     *        description="Unautorized.",
     *        @OA\JsonContent(
     *           @OA\Property(property="errors", type="object",
     *              @OA\Property(property="message", type="string", example="Unautorized"),
     *           ),
     *        ),
     *      ),
     * )
     */

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

    /**
     *
     * @OA\Put(
     *     path="/chat/{chatId}/message/{messageId}",
     *     operationId="updateMessage",
     *     tags={"Chat"},
     *     summary="Изменить сообщение чата",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\RequestBody(
     *        required=true,
     *        description = "Заполните поля для изменения сообщения чата",
     *        @OA\JsonContent(
     *           required={"text"},
     *           @OA\Property(property="text", type="string", example="Текст сообщения"),
     *       ),
     *     ),
     *     @OA\Response(
     *        response=204,
     *        description="Successful operation",
     *        @OA\JsonContent(),
     *      ),
     *     @OA\Response(
     *        response=401,
     *        description="Unauthenticated.",
     *        @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Unauthenticated"),
     *        ),
     *      ),
     *     @OA\Response(
     *        response=404,
     *        description="Message or chat not found.",
     *        @OA\JsonContent(
     *           @OA\Property(property="errors", type="object",
     *              @OA\Property(property="message", type="string", example="Message not found"),
     *           ),
     *        ),
     *      ),
     *     @OA\Response(
     *        response=403,
     *        description="Unautorized.",
     *        @OA\JsonContent(
     *           @OA\Property(property="errors", type="object",
     *              @OA\Property(property="message", type="string", example="Unautorized"),
     *           ),
     *        ),
     *      ),
     * )
     */

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

    /**
     *
     * @OA\Delete(
     *     path="/chat/{chatId}/message/{messageId}",
     *     operationId="deleteMessage",
     *     tags={"Chat"},
     *     summary="Удалить сообщение из чата",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Response(
     *        response=200,
     *        description="Successful operation",
     *        @OA\JsonContent(
     *           @OA\Property(property="id", type="int", example="1"),
     *           @OA\Property(property="text", type="string", example="Это текст сообщения!"),
     *           @OA\Property(property="author", type="object",
     *             @OA\Property(property="id", type="int", example="1"),
     *             @OA\Property(property="username", type="string", example="userreg1"),
     *             @OA\Property(property="firstname", type="string", example="Ivan"),
     *             @OA\Property(property="lastname", type="string", example="Ivanovich"),
     *          ),
     *          @OA\Property(property="chat_id", type="int", example="1"),
     *          @OA\Property(property="created_at", type="date", example="2021-04-04"),
     *        ),
     *      ),
     *     @OA\Response(
     *        response=401,
     *        description="Unauthenticated.",
     *        @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Unauthenticated"),
     *        ),
     *      ),
     *     @OA\Response(
     *        response=404,
     *        description="Message or chat not found.",
     *        @OA\JsonContent(
     *           @OA\Property(property="errors", type="object",
     *              @OA\Property(property="message", type="string", example="Message not found"),
     *           ),
     *        ),
     *      ),
     *     @OA\Response(
     *        response=403,
     *        description="Unautorized.",
     *        @OA\JsonContent(
     *           @OA\Property(property="errors", type="object",
     *              @OA\Property(property="message", type="string", example="Unautorized"),
     *           ),
     *        ),
     *      ),
     * )
     *
     * @return JsonResponse
     */
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
    /**
     * @OA\Get(
     *     path="/chat/{chatId}",
     *     operationId="getChatMessages",
     *     tags={"Chat"},
     *     summary="Получить сообщения чата",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Response(
     *        response=200,
     *        description="Successful operation",
     *        @OA\JsonContent(
     *           @OA\Property(property="id", type="int", example="1"),
     *           @OA\Property(property="text", type="string", example="Это текст сообщения!"),
     *           @OA\Property(property="author", type="object",
     *             @OA\Property(property="id", type="int", example="1"),
     *             @OA\Property(property="username", type="string", example="userreg1"),
     *             @OA\Property(property="firstname", type="string", example="Ivan"),
     *             @OA\Property(property="lastname", type="string", example="Ivanovich"),
     *          ),
     *          @OA\Property(property="chat_id", type="int", example="1"),
     *          @OA\Property(property="created_at", type="date", example="2021-04-04"),
     *        ),
     *      ),
     *     @OA\Response(
     *        response=401,
     *        description="Unauthenticated.",
     *        @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Unauthenticated"),
     *        ),
     *      ),
     *     @OA\Response(
     *        response=404,
     *        description="Chat not found.",
     *        @OA\JsonContent(
     *           @OA\Property(property="errors", type="object",
     *              @OA\Property(property="message", type="string", example="Chat not found"),
     *           ),
     *        ),
     *      ),
     *     @OA\Response(
     *        response=403,
     *        description="Unautorized.",
     *        @OA\JsonContent(
     *           @OA\Property(property="errors", type="object",
     *              @OA\Property(property="message", type="string", example="Unautorized"),
     *           ),
     *        ),
     *      ),
     * )
     *
     * @return JsonResponse
     */

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

    /**
     * Получение чатов по задаче (только для пользователя с типом заказчик)
     *
     * @OA\Get(
     *     path="/task/{taskId}/chats",
     *     operationId="getChatsByTask",
     *     tags={"Chat"},
     *     summary="Получить чаты по задаче",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Response(
     *        response=200,
     *        description="Successful operation",
     *        @OA\JsonContent(
     *           @OA\Property(property="id", type="int", example="1"),
     *           @OA\Property(property="customer", type="object",
     *             @OA\Property(property="id", type="int", example="1"),
     *             @OA\Property(property="username", type="string", example="userreg1"),
     *             @OA\Property(property="firstname", type="string", example="Ivan"),
     *             @OA\Property(property="lastname", type="string", example="Ivanovich"),
     *          ),
     *          @OA\Property(property="executor", type="object",
     *             @OA\Property(property="id", type="int", example="1"),
     *             @OA\Property(property="username", type="string", example="userreg1"),
     *             @OA\Property(property="firstname", type="string", example="Ivan"),
     *             @OA\Property(property="lastname", type="string", example="Ivanovich"),
     *          ),
     *
     *          @OA\Property(property="task", type="object",
     *             @OA\Property(property="id", type="int", example="1"),
     *             @OA\Property(property="name", type="string", example="Создать рекламу"),
     *             @OA\Property(property="description", type="string", example="Создать рекламу на тему пиар"),
     *             @OA\Property(property="price", type="int", example="1200"),
     *             @OA\Property(property="views", type="int", example="15"),
     *             @OA\Property(property="status", type="string", example="Busy"),
     *             @OA\Property(property="categories", type="object",
     *               @OA\Property(property="id", type="int", example="1"),
     *               @OA\Property(property="name", type="string", example="Video"),
     *             ),
     *             @OA\Property(property="created_at", type="date", example="2021-04-04"),
     *          ),
     *        ),
     *      ),
     *     @OA\Response(
     *        response=401,
     *        description="Unauthenticated.",
     *        @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Unauthenticated"),
     *        ),
     *      ),
     *     @OA\Response(
     *        response=404,
     *        description="Task not found.",
     *        @OA\JsonContent(
     *           @OA\Property(property="errors", type="object",
     *              @OA\Property(property="message", type="string", example="Task not found"),
     *           ),
     *        ),
     *      ),
     *     @OA\Response(
     *        response=403,
     *        description="Unautorized.",
     *        @OA\JsonContent(
     *           @OA\Property(property="errors", type="object",
     *              @OA\Property(property="message", type="string", example="Unautorized"),
     *           ),
     *        ),
     *      ),
     * )
     *
     * @return JsonResponse
     */

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

    /**
     * Получение всех чатов (только для пользователя с типом исполнитель)
     *
     * @OA\Get(
     *     path="/chats",
     *     operationId="getChats",
     *     tags={"Chat"},
     *     summary="Получить все чаты",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Response(
     *        response=200,
     *        description="Successful operation",
     *        @OA\JsonContent(
     *           @OA\Property(property="id", type="int", example="1"),
     *
     *           @OA\Property(property="customer", type="object",
     *             @OA\Property(property="id", type="int", example="1"),
     *             @OA\Property(property="username", type="string", example="userreg1"),
     *             @OA\Property(property="firstname", type="string", example="Ivan"),
     *             @OA\Property(property="lastname", type="string", example="Ivanovich"),
     *          ),
     *          @OA\Property(property="executor", type="object",
     *             @OA\Property(property="id", type="int", example="1"),
     *             @OA\Property(property="username", type="string", example="userreg1"),
     *             @OA\Property(property="firstname", type="string", example="Ivan"),
     *             @OA\Property(property="lastname", type="string", example="Ivanovich"),
     *          ),
     *
     *          @OA\Property(property="task", type="object",
     *             @OA\Property(property="id", type="int", example="1"),
     *             @OA\Property(property="name", type="string", example="Создать рекламу"),
     *             @OA\Property(property="description", type="string", example="Создать рекламу на тему пиар"),
     *             @OA\Property(property="price", type="int", example="1200"),
     *             @OA\Property(property="views", type="int", example="15"),
     *             @OA\Property(property="status", type="string", example="Busy"),
     *             @OA\Property(property="categories", type="object",
     *               @OA\Property(property="id", type="int", example="1"),
     *               @OA\Property(property="name", type="string", example="Video"),
     *             ),
     *             @OA\Property(property="created_at", type="date", example="2021-04-04"),
     *          ),
     *        ),
     *      ),
     *     @OA\Response(
     *        response=401,
     *        description="Unauthenticated.",
     *        @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Unauthenticated"),
     *        ),
     *      ),
     *     @OA\Response(
     *        response=403,
     *        description="Unautorized.",
     *        @OA\JsonContent(
     *           @OA\Property(property="errors", type="object",
     *              @OA\Property(property="message", type="string", example="Unautorized"),
     *           ),
     *        ),
     *      ),
     * )
     *
     * @return JsonResponse
     */

    //Получение чатов исполнителя
    public function getChats(Request $request)
    {
        $user = $request->user();
        if($user->user_type_id !== 1)
            return $this->error('Unautorized', 403);

        return $this->success(ChatResource::collection($user->executorChats));
    }
}
