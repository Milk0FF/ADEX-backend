<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
     /**
     *
     * @OA\Post(
     *     path="/user/register",
     *     operationId="doRegister",
     *     tags={"Auth"},
     *     summary="Регистрация пользователя",
     *     @OA\RequestBody(
     *        required=true,
     *        description = "Заполните поля для создания чата (user_type: 1 - исполнитель, 2 - заказчик)",
     *        @OA\JsonContent(
     *           required={"email", "password", "repeat_password", "user_type"},
     *           @OA\Property(property="email", format="email", type="string", example="test@test.ru"),
     *           @OA\Property(property="password", format="password", type="string", example="qwer123ty"),
     *           @OA\Property(property="repeat_password", format="password", type="string", example="qwer123ty"),
     *           @OA\Property(property="user_type", type="string", example="1"),
     *       ),
     *     ),
     *     @OA\Response(
     *        response=204,
     *        description="Successful operation",
     *        @OA\JsonContent(),
     *      ),
     * )
     */


    //Регистрация пользователя
    public function doRegister(RegisterRequest $request)
    {
        $data = $request->all();
        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'user_type_id' => $data['user_type']
        ]);
        $userInfo = UserInfo::create();
        $userInfo->employment_type_id = 1;
        $userInfo->save();

        $user->username = 'userreg' . $user->id;
        $user->user_info_id = $userInfo->id;
        $user->save();

        $token = $user->createToken('auth')->plainTextToken;

        return $this->success([
            'token' => $token,
            'user_type' => $user->user_type_id,
        ], 201);
    }
}
