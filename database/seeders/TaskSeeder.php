<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    private $tasks = [
        ['name' => 'Пиар вконтакте', 'description' => 'Пропиарить страницу вконтакте', 'price' => 2000.00, 'views' => 100,
         'executor_id' => 1, 'customer_id' => 2, 'task_status_id' => 3 ],
         ['name' => 'Создание билборда', 'description' => 'Создать билборд на тему автоспорт', 'price' => 5000.00, 'views' => 10,
          'executor_id' => 1, 'customer_id' => 2, 'task_status_id' => 3 ],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->tasks as $task){
            Task::updateOrCreate($task);
        }
    }
}
