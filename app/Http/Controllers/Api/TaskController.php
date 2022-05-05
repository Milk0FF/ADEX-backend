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
    //Создание задачи
    public function createTask(CreateTaskRequest $request)
    {
        $user = $request->user();
        if($user->user_type_id !== 2)
            return $this->error('Unathorized', 403);

        $data = $request->validated();
        $task = Task::create(['name' => $data['name'], 'price' => $data['price'], 'description' => $data['description'], 'customer_id' => $user->id, 'task_status_id' => 1]);

        if(!$task)
            return $this->error('Failed created message');

        $task->categoryWorks()->attach($data['categories']);

        return $this->success(new TaskResource($task));
    }

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

    //Получение информации о задаче
    public function getTaskInfo(int $taskId)
    {
        $task = Task::find($taskId);
        if(!$task)
            return $this->error('Task not found', 404);

        return $this->success(new TaskResource($task));
    }

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
