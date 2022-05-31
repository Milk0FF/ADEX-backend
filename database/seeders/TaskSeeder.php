<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    private $tasks = [
        [
            'name' => 'Пиар вконтакте',
            'description' => 'Пропиарить страницу вконтакте',
            'price' => 2000.00,
            'views' => 0,
            'executor_id' => 1,
            'customer_id' => 2,
            'task_status_id' => 3,
            'categories' => [2]
        ],
        [
            'name' => 'Создание билборда',
            'description' => 'Создать билборд на тему автоспорт',
            'price' => 5000.00,
            'views' => 0,
            'executor_id' => null,
            'customer_id' => 2,
            'task_status_id' => 1,
            'categories' => [1, 3]
        ],
        [
            'name' => 'Реклама у блогера',
            'description' => 'Дайте мне блогера, который меня прорекламирует на YouTube',
            'price' => 20000.00,
            'views' => 0,
            'executor_id' => null,
            'customer_id' => 2,
            'task_status_id' => 1,
            'categories' => [2]
        ],
        [
            'name' => 'Создать рекламный щит',
            'description' => 'Создайте рекламный щит на тему героев победоносцев города-героя Волгограда',
            'price' => 4000.00,
            'views' => 0,
            'executor_id' => null,
            'customer_id' => 2,
            'task_status_id' => 1,
            'categories' => [1]
        ],
        [
            'name' => 'Сделать прыгскок',
            'description' => 'Побрыгскочим сучки',
            'price' => 1000.00,
            'views' => 0,
            'executor_id' => null,
            'customer_id' => 2,
            'task_status_id' => 1,
            'categories' => [1, 2, 3]
        ],
        [
            'name' => 'Порекламим',
            'description' => 'Давайте рекламить и делать бабки',
            'price' => 3000.00,
            'views' => 0,
            'executor_id' => null,
            'customer_id' => 2,
            'task_status_id' => 1,
            'categories' => [1, 2, 3]
        ],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->tasks as $task) {
            $createdTask = Task::updateOrCreate([
                'name' => $task['name'],
                'description' => $task['description'],
                'price' => $task['price'],
                'views' => $task['views'],
                'date_end' =>  Carbon::createFromDate(2022, 05, 05),
                'executor_id' => $task['executor_id'],
                'customer_id' => $task['customer_id'],
                'task_status_id' => $task['task_status_id'],
            ]);
            $createdTask->categoryWorks()->attach($task['categories']);
        }
    }
}
