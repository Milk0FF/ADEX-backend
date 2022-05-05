<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryWorksResource;
use App\Models\CategoryWork;

class CategoryWorkController extends Controller
{
    //Получение категорий по рекламе
    public function getCategoryWorks()
    {
        return $this->success(CategoryWorksResource::collection(CategoryWork::all()));
    }
}
