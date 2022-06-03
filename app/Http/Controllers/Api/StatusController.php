<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StatusResource;
use App\Models\EmploymentType;
use App\Models\TaskStatus;

class StatusController extends Controller
{
    /**
     *
     * Получение типов занятости
     *
     * @OA\Get(
     *     path="/employment-types",
     *     operationId="getEmploymentTypes",
     *     tags={"User"},
     *     summary="Получение типов занятости",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Response(
     *        response=200,
     *        description="Successful operation",
     *        @OA\JsonContent(
     *           @OA\Property(property="id", type="int", example="1"),
     *           @OA\Property(property="name", type="int", example="Status"),
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

    //Получение типов занятости
    public function getEmploymentTypes()
    {
        $employmentTypes = EmploymentType::all();
        return $this->success(StatusResource::collection($employmentTypes));
    }

    /**
     *
     * Получение статусов задачи
     *
     * @OA\Get(
     *     path="/tasks/statuses",
     *     operationId="getTaskStatuses",
     *     tags={"Task"},
     *     summary="Получение статусов задачи",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Response(
     *        response=200,
     *        description="Successful operation",
     *        @OA\JsonContent(
     *           @OA\Property(property="id", type="int", example="1"),
     *           @OA\Property(property="name", type="int", example="Status"),
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

    //Получение статусов задачи
    public function getTaskStatuses()
    {
        $taskStatuses = TaskStatus::all();
        return $this->success(StatusResource::collection($taskStatuses));
    }
}
