<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    /**
     *
     * @OA\Post(
     *     path="/user/login",
     *     operationId="doLogin",
     *     tags={"Auth"},
     *     summary="Авторизация пользователя",
     *     @OA\RequestBody(
     *        required=true,
     *        description = "Заполните поля для авторизации",
     *        @OA\JsonContent(
     *           required={"email", "password"},
     *           @OA\Property(property="email", type="string", format="email", example="user1@mail.ru"),
     *           @OA\Property(property="password", type="string", format="password", example="qwerty123"),
     *       ),
     *     ),
     *     @OA\Response(
     *        response=200,
     *        description="Successful operation",
     *        @OA\JsonContent(
    *           @OA\Property(property="token", type="string", example="3|sGwGZYq5xGMcsrDHh1ewDCGBm630Tg8OPdlbtwNe"),
    *           @OA\Property(property="user_type", type="int", example="1"),
     *        ),
     *      ),
     *     @OA\Response(
     *        response=422,
     *        description="Login or password incorrect",
     *        @OA\JsonContent(
     *           @OA\Property(property="errors", type="object",
     *              @OA\Property(property="message", type="string", example="Login or password incorrect"),
     *           ),
     *        ),
     *      ),
     *
     * )
     */

    //Авторизация пользователя
    public function doLogin(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if(!Auth::attempt($credentials))
            return $this->error('Login or password incorrect', 422);

        $user = User::where('email', $credentials['email'])->first();
        $token = $user->createToken('auth')->plainTextToken;
        return $this->success([
            'token' => $token,
            'user_type' => $user->user_type_id,
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @OA\Post(
     *     path="/user/logout",
     *     operationId="logout",
     *     tags={"Auth"},
     *     summary="Выход из системы пользователя",
     *     security={
     *          {"bearer": {}}
     *     },
     *     @OA\Response(
     *        response=204,
     *        description="Successful operation",
     *        @OA\JsonContent(),
     *      ),
     *     @OA\Response(
     *        response=401,
     *        description="Unauthenticated.",
     *        @OA\JsonContent(
*               @OA\Property(property="message", type="string", example="Unauthenticated"),
     *        ),
     *      ),
     * )
     */

    //Выход из системы пользователя
    public function logout(Request $request){
        $authUser = $request->user();
        $authUser->tokens()->delete();
        return $this->success('', 204);
    }
}
