<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;

use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="ADEX documentation",
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="ADEX API Server"
 * )
*/

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * @param array $data
     * @param int $status_code
     * @return JsonResponse
     */
    public function success($data = null, $status_code = 200): JsonResponse
    {
        return response()->json($data, $status_code);
    }

    /**
     * @param string $message
     * @param int $status_code
     * @return JsonResponse
     */
    public function error($message = '', $status_code = 500): JsonResponse
    {
        return response()->json([
            'errors' => [
                'message' => $message
            ],
        ], $status_code);
    }
}
