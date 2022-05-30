<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StatusResource;
use App\Models\EmploymentType;
use App\Models\TaskStatus;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    //Получение типов занятости
    public function getEmploymentTypes()
    {
        $employmentTypes = EmploymentType::all();
        return $this->success(StatusResource::collection($employmentTypes));
    }

    //Получение статусов задачи
    public function getTaskStatuses()
    {
        $taskStatuses = TaskStatus::all();
        return $this->success(StatusResource::collection($taskStatuses));
    }
}
