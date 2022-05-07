<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryWorksResource;
use App\Models\CategoryWork;

class CategoryWorkController extends Controller
{
    /**
     * @OA\Get(
     *     path="/category-works",
     *     operationId="getCategoryWorks",
     *     tags={"Category Works"},
     *     summary="Получить список категорий рекламы",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *            mediaType="application/json",
     *          )
     *      ),
     * )
     *
     * @return JsonResponse
     */

    //Получение категорий по рекламе
    public function getCategoryWorks()
    {
        return $this->success(CategoryWorksResource::collection(CategoryWork::all()));
    }
}
