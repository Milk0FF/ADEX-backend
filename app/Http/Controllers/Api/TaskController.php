<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Task\ChangeTaskStatusRequest;
use App\Http\Requests\Api\Task\CreateTaskRequest;
use App\Http\Requests\Api\Task\GetTasksRequest;
use App\Http\Requests\Api\Task\SetExecutorRequest;
use App\Http\Requests\Api\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
     /**
     *
     * Создать новую задачу (только для пользователей с типом заказчик)
     *
     * @OA\Post(
     *     path="/task",
     *     operationId="createTask",
     *     tags={"Task"},
     *     summary="Создать новую задачу",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\RequestBody(
     *        required=true,
     *        description = "Заполните поля для создания задачи",
     *        @OA\JsonContent(
     *           required={"name", "description", "categories", },
     *           @OA\Property(property="name", type="string", example="Название задачи"),
     *           @OA\Property(property="price", type="float", example="1200"),
     *           @OA\Property(property="description", type="string", example="Описание задачи"),
     *           @OA\Property(property="categories", type="int", example={2,3}),
     *       ),
     *     ),
     *     @OA\Response(
     *        response=200,
     *        description="Successful operation",
     *        @OA\JsonContent(
     *           @OA\Property(property="id", type="int", example="1"),
     *           @OA\Property(property="name", type="string", example="Создать рекламу"),
     *           @OA\Property(property="description", type="string", example="Создать рекламу на тему пиар"),
     *           @OA\Property(property="price", type="int", example="1200"),
     *           @OA\Property(property="views", type="int", example="15"),
     *           @OA\Property(property="status", type="string", example="Busy"),
     *           @OA\Property(property="categories", type="object",
     *             @OA\Property(property="id", type="int", example="1"),
     *             @OA\Property(property="name", type="string", example="Video"),
     *           ),
     *           @OA\Property(property="created_at", type="date", example="2021-04-04"),
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
     *        description="Unautorized",
     *        @OA\JsonContent(
     *           @OA\Property(property="errors", type="object",
     *              @OA\Property(property="message", type="string", example="Unautorized"),
     *           ),
     *        ),
     *      ),
     * )
     */
    //Создание задачи
    public function createTask(CreateTaskRequest $request)
    {
        $user = $request->user();
        if($user->user_type_id !== 2)
            return $this->error('Unathorized', 403);

        $data = $request->validated();
        $task = Task::create(['name' => $data['name'], 'price' => $data['price'], 'description' => $data['description'], 'customer_id' => $user->id, 'task_status_id' => 1]);

        $task->categoryWorks()->attach($data['categories']);

        return $this->success(new TaskResource($task));
    }

    /**
     *
     * Изменить данные задачи (только для пользователей с типом заказчик)
     *
     * @OA\Put(
     *     path="/task/{taskId}",
     *     operationId="updateTask",
     *     tags={"Task"},
     *     summary="Изменить данные задачи",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\RequestBody(
     *        required=true,
     *        description = "Заполните поля для изменения задачи",
     *        @OA\JsonContent(
     *           required={ },
     *           @OA\Property(property="name", type="string", example="Название задачи"),
     *           @OA\Property(property="price", type="float", example="1200"),
     *           @OA\Property(property="description", type="string", example="Описание задачи"),
     *           @OA\Property(property="categories", type="int", example={2,3}),
     *       ),
     *     ),
     *     @OA\Response(
     *        response=204,
     *        description="Successful operation",
     *        @OA\JsonContent(),
     *      ),
     *     @OA\Response(
     *        response=404,
     *        description="Task not found",
     *        @OA\JsonContent(
     *           @OA\Property(property="errors", type="object",
     *              @OA\Property(property="message", type="string", example="Task not found"),
     *           ),
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
     *        description="Unautorized",
     *        @OA\JsonContent(
     *           @OA\Property(property="errors", type="object",
     *              @OA\Property(property="message", type="string", example="Unautorized"),
     *           ),
     *        ),
     *      ),
     * )
     */
    //Изменение задачи
    public function updateTask(UpdateTaskRequest $request, int $taskId)
    {
        $data = $request->validated();
        $task = Task::find($taskId);
        if(!$task)
            return $this->error('Task not found', 404);

        $task->update($data);
        if(isset($data['categories']))
            $task->categoryWorks()->sync($data['categories']);

        return $this->success('', 204);
    }
    /**
     *
     * @OA\Get(
     *     path="/task/{taskId}",
     *     operationId="getTaskInfo",
     *     tags={"Task"},
     *     summary="Получение информации о задаче",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Response(
     *        response=200,
     *        description="Successful operation",
     *        @OA\JsonContent(
     *           @OA\Property(property="id", type="int", example="1"),
     *           @OA\Property(property="name", type="string", example="Создать рекламу"),
     *           @OA\Property(property="description", type="string", example="Создать рекламу на тему пиар"),
     *           @OA\Property(property="price", type="int", example="1200"),
     *           @OA\Property(property="views", type="int", example="15"),
     *           @OA\Property(property="status", type="string", example="Busy"),
     *           @OA\Property(property="categories", type="object",
     *             @OA\Property(property="id", type="int", example="1"),
     *             @OA\Property(property="name", type="string", example="Video"),
     *           ),
     *           @OA\Property(property="created_at", type="date", example="2021-04-04"),
     *        ),
     *      ),
     *     @OA\Response(
     *        response=401,
     *        description="Unauthenticated",
     *        @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Unauthenticated"),
     *        ),
     *      ),
     *     @OA\Response(
     *        response=404,
     *        description="Task not found",
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

    //Получение информации о задаче
    public function getTaskInfo(int $taskId)
    {
        $task = Task::find($taskId);
        if(!$task)
            return $this->error('Task not found', 404);

        return $this->success(new TaskResource($task));
    }
    /**
     *
     * @OA\Get(
     *     path="/tasks",
     *     operationId="getTasks",
     *     tags={"Task"},
     *     summary="Получить задачи с фильтрами",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Response(
     *        response=200,
     *        description="Successful operation",
     *        @OA\JsonContent(
     *           @OA\Property(property="id", type="int", example="1"),
     *           @OA\Property(property="name", type="string", example="Создать рекламу"),
     *           @OA\Property(property="description", type="string", example="Создать рекламу на тему пиар"),
     *           @OA\Property(property="price", type="int", example="1200"),
     *           @OA\Property(property="views", type="int", example="15"),
     *           @OA\Property(property="status", type="string", example="Busy"),
     *           @OA\Property(property="categories", type="object",
     *             @OA\Property(property="id", type="int", example="1"),
     *             @OA\Property(property="name", type="string", example="Video"),
     *           ),
     *           @OA\Property(property="created_at", type="date", example="2021-04-04"),
     *        ),
     *      ),
     *     @OA\Response(
     *        response=401,
     *        description="Unauthenticated",
     *        @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Unauthenticated"),
     *        ),
     *      ),
     * )
     *
     * @return JsonResponse
     */

    //Получение задач с фильтрами по категориям
    public function getTasks(GetTasksRequest $request)
    {
        $data = $request->validated();
        $query = Task::where('task_status_id', 1);

        if(isset($data['categories']))
            $query->whereHas('categoryWorks', function($q) use ($data){
                $q->whereIn('category_works.id', $data['categories']);
            });
        if(isset($data['price_start']) && isset($data['price_end']))
            $query->whereBetween('price', [$data['price_start'], $data['price_end']]);

        $tasks = $query->get();

        return $this->success(TaskResource::collection($tasks));
    }


    /**
     *
     * Удалить задачу ( доступно только для пользователя с типом заказчик)
     *
     * @OA\Delete(
     *     path="/task/{taskId}",
     *     operationId="deleteTask",
     *     tags={"Task"},
     *     summary="Удалить задачу",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Response(
     *        response=204,
     *        description="Successful operation",
     *        @OA\JsonContent(),
     *      ),
     *     @OA\Response(
     *        response=404,
     *        description="Task not found",
     *        @OA\JsonContent(
     *           @OA\Property(property="errors", type="object",
     *              @OA\Property(property="message", type="string", example="Task not found"),
     *           ),
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
     *        description="Unautorized",
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
    //Удаление задачи
    public function deleteTask(Request $request, int $taskId)
    {
        $user = $request->user();
        $task = Task::find($taskId);

        if(!$task)
            return $this->error('Task not found', 404);
        if($task->customer->id !== $user->id)
            return $this->error('Unathorized', 403);

        $task->categoryWorks()->sync([]);
        $task->delete();

        return $this->success('', 204);
    }

    /**
     *
     * Изменить статус задачи ( доступно только для пользователя с типом заказчик)
     *
     * @OA\Post(
     *     path="/task/{taskId}/status",
     *     operationId="setTaskStatus",
     *     tags={"Task"},
     *     summary="Изменить статус задачи",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Response(
     *        response=204,
     *        description="Successful operation",
     *        @OA\JsonContent(),
     *      ),
     *     @OA\Response(
     *        response=404,
     *        description="Task not found",
     *        @OA\JsonContent(
     *           @OA\Property(property="errors", type="object",
     *              @OA\Property(property="message", type="string", example="Task not found"),
     *           ),
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
     *        description="Unautorized",
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

    //Изменение статуса задачи
    public function setTaskStatus(ChangeTaskStatusRequest $request, int $taskId)
    {
        $task = Task::find($taskId);
        if(!$task)
            return $this->error('Task not found', 404);

        $user = $request->user();
        if($task->executor_id == $user->id || $task->customer_id == $user->id){
            $data = $request->validated();

            $task->task_status_id = $data['task_status'];
            $task->save();

            return $this->success('', 204);
        }
        return $this->error('Unathorized', 403);
    }

    /**
     *
     * Изменить исполнителя задачи ( доступно только для пользователя с типом заказчик)
     *
     * @OA\Post(
     *     path="/task/{taskId}/executor",
     *     operationId="setExecutor",
     *     tags={"Task"},
     *     summary="Изменить исполнителя задачи",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Response(
     *        response=204,
     *        description="Successful operation",
     *        @OA\JsonContent(),
     *      ),
     *     @OA\Response(
     *        response=404,
     *        description="Task not found",
     *        @OA\JsonContent(
     *           @OA\Property(property="errors", type="object",
     *              @OA\Property(property="message", type="string", example="Task not found"),
     *           ),
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
     *        description="Unautorized",
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

    //Добавление исполнителя к зкдаче
    public function setExecutor(SetExecutorRequest $request, int $taskId)
    {
        $user = $request->user();
        if($user->user_type_id !== 2)
            return $this->error('Unathorized', 403);

        $task = Task::find($taskId);
        if(!$task)
            return $this->error('Task not found', 404);

        $data = $request->validated();
        $task->executor_id = $data['executor_id'];
        $task->save();

        return $this->success('', 204);

    }

    /**
     *
     * @OA\Post(
     *     path="/task/{taskId}/views",
     *     operationId="incrementViews",
     *     tags={"Task"},
     *     summary="Увеличение просмотров задачи",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Response(
     *        response=204,
     *        description="Successful operation",
     *        @OA\JsonContent(),
     *      ),
     *     @OA\Response(
     *        response=404,
     *        description="Task not found",
     *        @OA\JsonContent(
     *           @OA\Property(property="errors", type="object",
     *              @OA\Property(property="message", type="string", example="Task not found"),
     *           ),
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
     *        description="Unautorized",
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

    //Увеличение просмотров задачи
    public function incrementViews(Request $request, int $taskId)
    {
        $user = $request->user();
        if($user->user_type_id !== 2)
            return $this->error('Unathorized', 403);

        $task = Task::find($taskId);
        if(!$task)
            return $this->error('Task not found', 404);

        $task->views = $task->views + 1;
        $task->save();

        return $this->success('', 204);

    }
}
