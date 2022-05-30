<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    //Получение максимальной и минимальной
    public function getPrices(Request $request)
    {
        $user = $request->user();
        if($user->user_type_id !== 1)
            return $this->error('Unathorized', 403);

        $minPrice = Task::where('task_status_id', 1)->get()->min('price');
        $maxPrice = Task::where('task_status_id', 1)->get()->max('price');

        return $this->success([
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
        ]);
    }
}
