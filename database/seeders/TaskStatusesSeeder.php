<?php

namespace Database\Seeders;

use App\Models\TaskStatus;
use Illuminate\Database\Seeder;

class TaskStatusesSeeder extends Seeder
{
    private $taskStatuses = [
        ['name' => 'Создано'],
        ['name' => 'Отменено'],
        ['name' => 'Исполнитель выбран'],
        ['name' => 'В процессе выполнения'],
        ['name' => 'Выполнено'],
        ['name' => 'Не выполнено'],
        ['name' => 'Завершено'],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->taskStatuses as $taskStatus){
            TaskStatus::updateOrCreate($taskStatus);
        }
    }
}
