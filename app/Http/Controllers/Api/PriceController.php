<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    /**
     *
     * Получение максимальной и минимальной цены по задачам
     *
     * @OA\Get(
     *     path="/tasks/prices",
     *     operationId="getPrices",
     *     tags={"Task"},
     *     summary="Получение максимальной и минимальной цены",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Response(
     *        response=200,
     *        description="Successful operation",
     *        @OA\JsonContent(
     *           @OA\Property(property="min_price", type="int", example="10000"),
     *           @OA\Property(property="max_price", type="int", example="40000"),
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

    //Получение максимальной и минимальной цены по задачам
    public function getPrices(Request $request)
    {
        $minPrice = Task::where('task_status_id', 1)->get()->min('price');
        $maxPrice = Task::where('task_status_id', 1)->get()->max('price');

        return $this->success([
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
        ]);
    }
}
