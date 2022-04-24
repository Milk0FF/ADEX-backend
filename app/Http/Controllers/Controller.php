<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function success($data = null, $status_code = 200): JsonResponse
    {
        return response()->json($data, $status_code);
    }
    public function error($message = '', $status_code = 500): JsonResponse
    {
        !is_array($message) ? $message = [$message] : null;
        return response()->json([
            'errors' => [
                'message' => $message
            ],
        ], $status_code);
    }
}
